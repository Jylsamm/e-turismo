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
    public function adminReviews()
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

        return view('verification.admin_reviews', compact('pending', 'rejected', 'verified'));
    }

    /**
     * Admin: verify account status.
     */
    public function adminAccounts()
    {
        $this->authorize('admin-only');

        $allUsers = User::where('role', '!=', 'staff')->latest()->get();

        return view('verification.admin_accounts', compact('allUsers'));
    }

    /**
     * Admin: add a new account.
     */
    public function adminAddAccount()
    {
        $this->authorize('admin-only');

        // Exclude destinations already assigned to another staff member
        $assignedDestinationIds = User::where('role', 'staff')
            ->whereNotNull('assigned_destination_id')
            ->pluck('assigned_destination_id')
            ->toArray();

        $destinations = Destination::whereNotIn('id', $assignedDestinationIds)
            ->orderBy('name')
            ->get();

        return view('verification.admin_add_account', compact('destinations'));
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
    public function adminStoreAccount(Request $request)
    {
        $this->authorize('admin-only');

        $email = strtolower(trim($request->email));
        if (!app()->environment('testing') && $email !== strtolower(session('otp_verified_email'))) {
            return back()->withErrors(['email' => 'The email address must be verified via OTP first.'])->withInput();
        }

        $rules = [
            'email'                     => 'required|string|email|max:255|unique:users|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i',
            'contact'                   => 'required|string|max:50',
            'password'                  => ['required', 'confirmed', Rules\Password::defaults()],
            'assigned_destination_name' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $dest = Destination::where('name', $value)->first();
                        if ($dest) {
                            $alreadyAssigned = User::where('role', 'staff')
                                ->where('assigned_destination_id', $dest->id)
                                ->exists();
                            if ($alreadyAssigned) {
                                $fail('The destination spot "' . $value . '" is already assigned to another staff member.');
                            }
                        }
                    }
                }
            ]
        ];

        $request->validate($rules);

        // Derive name from email prefix
        $emailPrefix = explode('@', $email)[0];
        $firstName = ucwords(str_replace(['.', '_', '-'], ' ', $emailPrefix));
        $lastName = 'Staff';

        $destId = null;
        if ($request->filled('assigned_destination_name')) {
            $dest = Destination::where('name', $request->assigned_destination_name)->first();
            if (!$dest) {
                $dest = Destination::create(['name' => $request->assigned_destination_name]);
            }
            $destId = $dest->id;
        }

        $userData = [
            'name'                      => $firstName,
            'last_name'                 => $lastName,
            'email'                     => $email,
            'password'                  => Hash::make($request->password),
            'role'                      => 'staff',
            'contact'                   => $request->contact,
            'email_verified_at'         => now(),
            'assigned_destination_id'   => $destId,
            'id_verification_status'    => 'verified',
            'id_verification_score'     => 100.00,
            'id_verified_at'            => now(),
        ];

        User::create($userData);

        // Clear the OTP verified session
        session()->forget('otp_verified_email');

        return redirect()->route('verification.staff')->with('success', "New Staff account registered successfully.");
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

    /**
     * Admin: manage staff accounts page.
     */
    public function adminStaff()
    {
        $this->authorize('admin-only');

        $staffUsers = \App\Models\User::where('role', 'staff')->latest()->get();
        $destinations = \App\Models\Destination::orderBy('name')->get();

        return view('verification.admin_staff', compact('staffUsers', 'destinations'));
    }

    /**
     * Admin: reassign staff member's destination spot.
     */
    public function reassignStaff(Request $request, \App\Models\User $user)
    {
        $this->authorize('admin-only');

        $request->validate([
            'assigned_destination_id' => [
                'nullable',
                'exists:destinations,id',
                function ($attribute, $value, $fail) use ($user) {
                    if ($value) {
                        $alreadyAssigned = User::where('role', 'staff')
                            ->where('id', '!=', $user->id)
                            ->where('assigned_destination_id', $value)
                            ->exists();
                        if ($alreadyAssigned) {
                            $fail('The selected destination spot is already assigned to another staff member.');
                        }
                    }
                }
            ]
        ]);

        $user->update([
            'assigned_destination_id' => $request->assigned_destination_id
        ]);

        return back()->with('success', "Reassigned spot destination for {$user->name} successfully.");
    }

    /**
     * Admin: delete/remove a staff account.
     */
    public function deleteStaff(\App\Models\User $user)
    {
        $this->authorize('admin-only');

        if ($user->id === auth()->id()) {
            return back()->withErrors('You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', "Staff account {$user->name} deleted successfully.");
    }

    /**
     * Admin: update a staff member's details.
     */
    public function updateStaff(Request $request, \App\Models\User $user)
    {
        $this->authorize('admin-only');

        $rules = [
            'name'      => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $user->id . '|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i',
            'contact'   => 'required|string|max:50',
            'password'  => 'nullable|string|min:8|confirmed',
        ];

        $request->validate($rules);

        $userData = [
            'name'      => trim($request->name),
            'last_name' => trim($request->last_name),
            'email'     => strtolower(trim($request->email)),
            'contact'   => trim($request->contact),
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return back()->with('success', "Staff member {$user->name}'s details updated successfully.");
    }
}
