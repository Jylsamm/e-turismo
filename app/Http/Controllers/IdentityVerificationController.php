<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Destination;
use App\Services\IdentityVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IdentityVerificationController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private IdentityVerificationService $verifier) {}

    /**
     * Note: The show() method has been removed as the verification UI is now embedded in the Profile page.
     */

    /**
     * Tourist resubmits a new ID photo after rejection.
     */
    public function resubmit(Request $request)
    {
        $request->validate([
            'id_photo' => 'required|file|mimes:jpg,jpeg,png,pdf,gif,tiff,bmp|max:20480',
        ]);

        $user = auth()->user();

        if (RateLimiter::tooManyAttempts('id-verify:' . $user->id, 3)) {
            return back()->with('error', 'Too many verification attempts today. Try again tomorrow.');
        }
        RateLimiter::hit('id-verify:' . $user->id, 86400);

        if (!in_array($user->id_verification_status, ['unverified', 'rejected'])) {
            return back()->with('error', 'Your identity is already verified or under review.');
        }

        // Delete old photo if exists
        if ($user->id_photo) {
            Storage::disk('public')->delete($user->id_photo);
        }

        $file = $request->file('id_photo');
        $path = $file->storeAs('id_photos', time() . '_' . strtolower($file->getClientOriginalName()), 'public');

        $user->update([
            'id_photo'                => $path,
            'id_verification_status'  => 'unverified',
            'id_verification_score'   => null,
            'id_verification_notes'   => null,
            'id_verified_at'          => null,
            'ready_to_complete_requirements' => true,
            'is_manually_verified'    => false, // reset manual flag on new upload
        ]);

        // Run verification immediately
        $result = $this->verifier->verify($user->fresh());
        $user->update([
            'id_verification_status' => $result['status'],
            'id_verification_score'  => $result['score'],
            'id_verification_notes'  => $result['notes'],
            'id_verified_at'         => $result['status'] === 'verified' ? now() : null,
        ]);

        return redirect(route('profile.edit') . '#verification')
            ->with('success', 'ID photo resubmitted. Verification result: ' . strtoupper($result['status']) . '.');
    }

    /**
     * Tourist updates their registration details (Name, ID Info, DOB) after a mismatch rejection.
     */
    public function updateDetails(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'middle_initial' => 'nullable|string|max:10',
            'classification' => 'required|string|in:Local,Domestic,Foreign',
            'id_type'        => 'required|string|max:50',
            'id_number'      => 'required|string|max:50',
            'dob'            => 'required|date|before:today',
        ]);

        $user = auth()->user();

        if (!in_array($user->id_verification_status, ['unverified', 'rejected'])) {
            return back()->with('error', 'Your identity is already verified or under review.');
        }

        // Compose full name
        $nameParts = array_filter([
            trim($request->first_name),
            $request->middle_initial ? strtoupper(rtrim($request->middle_initial, '.')) . '.' : null,
            trim($request->last_name),
        ]);
        $fullName = implode(' ', $nameParts);

        $user->update([
            'name'           => $fullName,
            'last_name'      => trim($request->last_name),
            'middle_initial' => $request->middle_initial
                                    ? strtoupper(rtrim($request->middle_initial, '.')) . '.'
                                    : null,
            'classification' => $request->classification,
            'id_type'        => $request->id_type,
            'id_number'      => $request->id_number,
            'dob'            => $request->dob,
            'id_verification_status' => 'unverified',
        ]);

        // Re-run verification on existing photo
        if ($user->id_photo) {
            $result = $this->verifier->verify($user->fresh());
            $user->update([
                'id_verification_status' => $result['status'],
                'id_verification_score'  => $result['score'],
                'id_verification_notes'  => $result['notes'],
                'id_verified_at'         => $result['status'] === 'verified' ? now() : null,
            ]);
            
            return redirect(route('profile.edit') . '#verification')
                ->with('success', 'Details updated. Verification result: ' . strtoupper($result['status']) . '.');
        }

        return redirect(route('profile.edit') . '#verification')->with('success', 'Identity details updated successfully.');
    }

    /* ─── Admin actions ─────────────────────────────────────── */

    /**
     * Admin: list tourists awaiting manual review.
     */
    public function adminIndex()
    {
        $this->authorize('admin-only');

        $pending  = User::where('role', 'tourist')
                        ->where('id_verification_status', 'pending')
                        ->latest()->get();

        $rejected = User::where('role', 'tourist')
                        ->where('id_verification_status', 'rejected')
                        ->latest()->take(20)->get();

        $verified = User::where('role', 'tourist')
                        ->where('id_verification_status', 'verified')
                        ->latest()->take(20)->get();

        // Fetch all users and destinations for user management tab
        $allUsers     = User::latest()->get();
        $destinations = Destination::orderBy('name')->get();

        return view('verification.admin', compact('pending', 'rejected', 'verified', 'allUsers', 'destinations'));
    }

    /**
     * Admin: manually approve or reject a tourist.
     */
    public function adminDecide(Request $request, User $user)
    {
        $this->authorize('admin-only');

        $request->validate([
            'decision' => 'required|in:verified,rejected',
            'notes'    => 'nullable|string|max:500',
        ]);

        $user->update([
            'id_verification_status' => $request->decision,
            'is_manually_verified'   => true, // Mark manually verified/decided by admin
            'id_verification_notes'  => $request->notes ?? ($user->id_verification_notes . ' | Admin decision: ' . $request->decision),
            'id_verified_at'         => $request->decision === 'verified' ? now() : null,
        ]);

        return back()->with('success', "Tourist {$user->name} has been marked as {$request->decision}.");
    }

    /**
     * Admin: manually register a tourist or staff account.
     */
    public function adminStoreAccount(Request $request)
    {
        $this->authorize('admin-only');

        $isTourist = $request->input('role') === 'tourist';

        $rules = [
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'middle_initial' => 'nullable|string|max:10',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
            'role'           => 'required|in:tourist,staff',
            'contact'        => 'nullable|string|max:50',
        ];

        if ($isTourist) {
            $rules['classification'] = 'required|string|in:Local,Domestic,Foreign';
            $rules['id_type']        = 'required|string|max:50';
            $rules['id_number']      = 'required|string|max:50';
            $rules['dob']            = 'required|date|before:today';
        } else {
            $rules['assigned_destination_id'] = 'nullable|exists:destinations,id';
        }

        $request->validate($rules);

        // Compose full name
        $nameParts = array_filter([
            trim($request->first_name),
            $request->middle_initial ? strtoupper(rtrim($request->middle_initial, '.')) . '.' : null,
            trim($request->last_name),
        ]);
        $fullName = implode(' ', $nameParts);

        $userData = [
            'name'           => $fullName,
            'last_name'      => trim($request->last_name),
            'middle_initial' => $request->middle_initial ? strtoupper(rtrim($request->middle_initial, '.')) . '.' : null,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => $request->role,
            'contact'        => $request->contact,
            'email_verified_at' => now(), // Auto verify email since created by admin
        ];

        if ($isTourist) {
            $userData['classification']         = $request->classification;
            $userData['id_type']                = $request->id_type;
            $userData['id_number']              = $request->id_number;
            $userData['dob']                    = $request->dob;
            // Admin created tourist is manually verified by default
            $userData['id_verification_status'] = 'verified';
            $userData['id_verification_score']  = 100.00;
            $userData['id_verification_notes']  = 'Manually registered by Admin';
            $userData['id_verified_at']         = now();
            $userData['is_manually_verified']   = true;
            $userData['ready_to_complete_requirements'] = true;
        } else {
            $userData['assigned_destination_id'] = $request->assigned_destination_id;
            // Staff are always verified
            $userData['id_verification_status'] = 'verified';
            $userData['id_verification_score']  = 100.00;
            $userData['id_verified_at']         = now();
        }

        User::create($userData);

        return back()->with('success', "New " . ucfirst($request->role) . " account registered successfully.");
    }

    /**
     * Admin: manually update any account's status.
     */
    public function adminUpdateStatus(Request $request, User $user)
    {
        $this->authorize('admin-only');

        $request->validate([
            'status' => 'required|in:unverified,pending,verified,rejected',
            'notes'  => 'nullable|string|max:500',
        ]);

        $user->update([
            'id_verification_status' => $request->status,
            'is_manually_verified'   => true, // Lock manual verification
            'id_verification_notes'  => $request->notes ?? 'Status manually updated by Admin.',
            'id_verified_at'         => $request->status === 'verified' ? now() : null,
        ]);

        return back()->with('success', "Account {$user->name}'s identity status updated to " . strtoupper($request->status) . ".");
    }
}
