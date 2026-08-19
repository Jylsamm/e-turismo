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
     * Get live verification status of the authenticated user for real-time UI polling.
     */
    public function getStatus(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'status'         => $user->id_verification_status ?? 'pending',
            'is_verified'    => ($user->id_verification_status ?? '') === 'verified',
            'score'          => $user->id_verification_score,
            'notes'          => $user->id_verification_notes,
            'verified_at'    => $user->id_verified_at ? $user->id_verified_at->format('M d, Y') : null,
            'processing_ms'  => $user->ocr_processing_ms,
        ]);
    }

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
        $firstName = trim($request->first_name);
        $middleInitial = $request->middle_initial ? strtoupper(rtrim($request->middle_initial, '.')) . '.' : null;
        $lastName = trim($request->last_name);

        if ($middleInitial) {
            $rawMi = rtrim($middleInitial, '.');
            $firstName = preg_replace('/\s+' . preg_quote($rawMi, '/') . '\.?$/i', '', $firstName);
        }
        if ($lastName) {
            $firstName = preg_replace('/\s+' . preg_quote($lastName, '/') . '$/i', '', $firstName);
        }

        $nameParts = array_filter([$firstName, $middleInitial, $lastName]);
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
     * Admin: unified tourist identity verification & directory center.
     */
    public function adminReviews(Request $request)
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
<<<<<<< Updated upstream
                        ->latest()->take(20)->get();

        return view('verification.admin_reviews', compact('pending', 'rejected', 'verified'));
    }

    /**
     * Admin: verify account status.
     */
    public function adminAccounts()
    {
        $this->authorize('admin-only');
=======
                        ->latest()->get();
>>>>>>> Stashed changes

        $allUsers = User::where('role', '!=', 'staff')->latest()->get();

        $initialTab = $request->query('tab', ($pending->count() > 0 ? 'pending' : 'all'));

        return view('verification.admin_reviews', compact('pending', 'verified', 'allUsers', 'initialTab'));
    }

    /**
     * Admin: verify account status (redirects to unified tourist verification center).
     */
    public function adminAccounts(Request $request)
    {
        $this->authorize('admin-only');

        return redirect()->route('verification.reviews', ['tab' => $request->query('tab', 'all')]);
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

        // Normalize decision/status field
        if (!$request->has('decision')) {
            if ($request->has('status')) {
                $request->merge(['decision' => $request->input('status')]);
            } elseif ($request->has('id_verification_status')) {
                $request->merge(['decision' => $request->input('id_verification_status')]);
            }
        }

        $request->validate([
<<<<<<< Updated upstream
            'decision' => 'required|in:verified,rejected',
=======
            'decision' => 'required|in:pending,verified',
>>>>>>> Stashed changes
            'notes'    => 'nullable|string|max:500',
        ]);

        $decision = $request->decision;

        $user->update([
<<<<<<< Updated upstream
            'id_verification_status' => $request->decision,
            'is_manually_verified'   => true, // Mark manually verified/decided by admin
            'id_verification_notes'  => $request->notes ?? ($user->id_verification_notes . ' | Admin decision: ' . $request->decision),
            'id_verified_at'         => $request->decision === 'verified' ? now() : null,
        ]);

        return back()->with('success', "Tourist {$user->name} has been marked as {$request->decision}.");
=======
            'id_verification_status' => $decision,
            'is_manually_verified'   => $decision === 'verified',
            'id_verification_notes'  => $request->notes ?? ('Admin decision: ' . $decision),
            'id_verified_at'         => $decision === 'verified' ? now() : null,
        ]);

        return back()->with('success', "Tourist {$user->name} status set to " . strtoupper($decision) . ".");
>>>>>>> Stashed changes
    }

    /**
     * Admin: manually register a tourist or staff account.
     */
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
                $name = $request->assigned_destination_name;
                $cleanName = preg_replace('/[^a-zA-Z0-9]/', '', $name);
                $baseInitials = strtoupper(substr($cleanName, 0, 3));
                if (empty($baseInitials)) {
                    $baseInitials = 'DST';
                }
                
                $initials = $baseInitials;
                $counter = 1;
                while (Destination::where('initials', $initials)->exists()) {
                    $initials = substr($baseInitials, 0, 8) . $counter;
                    $counter++;
                }

                $dest = Destination::create([
                    'name'     => $name,
                    'initials' => $initials,
                    'location' => 'TBD',
                    'capacity' => 100
                ]);
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

        // Normalize status field if sent as id_verification_status or decision
        if (!$request->has('status')) {
            if ($request->has('id_verification_status')) {
                $request->merge(['status' => $request->input('id_verification_status')]);
            } elseif ($request->has('decision')) {
                $request->merge(['status' => $request->input('decision')]);
            }
        }

        $request->validate([
            'status' => 'required|in:pending,verified',
            'notes'  => 'nullable|string|max:500',
        ]);

        $status = $request->status;

        $user->update([
            'id_verification_status' => $status,
            'is_manually_verified'   => true, // Lock manual verification
            'id_verification_notes'  => $request->notes ?? 'Status manually updated by Admin.',
            'id_verified_at'         => $status === 'verified' ? now() : null,
        ]);

        return back()->with('success', "Identity status for {$user->fullName()} updated to " . strtoupper($status) . ".");
    }

    /**
     * Admin: manage staff accounts page.
     */
    public function adminStaff()
    {
        $this->authorize('admin-only');

        $staffUsers = User::where('role', 'staff')->latest()->get();
        $destinations = Destination::orderBy('name')->get();

        return view('verification.admin_staff', compact('staffUsers', 'destinations'));
    }

    /**
     * Admin: reassign staff member's destination spot.
     */
    public function reassignStaff(Request $request, User $user)
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
    public function deleteStaff(User $user)
    {
        $this->authorize('admin-only');

        if ($user->id === auth()->id()) {
            return back()->withErrors('You cannot delete your own account.');
        }

<<<<<<< Updated upstream
=======
        // Cascade delete the assigned destination if the staff has one
        if ($user->assigned_destination_id) {
            $destination = Destination::find($user->assigned_destination_id);
            if ($destination) {
                if ($destination->photos) {
                    Storage::disk('public')->delete($destination->photos);
                }
                // Also clean up any associated gallery images in storage
                foreach ($destination->images as $image) {
                    Storage::disk('public')->delete($image->path);
                }
                $destination->delete();
            }
        }

>>>>>>> Stashed changes
        $user->delete();

        return back()->with('success', "Staff account {$user->name} deleted successfully.");
    }

    /**
     * Admin: update a staff member's details.
     */
    public function updateStaff(Request $request, User $user)
    {
        $this->authorize('admin-only');

        // Flash the user ID so the modal can reopen on validation error
        $request->session()->flash('edit_user_id', $user->id);

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

    /**
     * Admin: Trigger automated OCR scan and auto-approval on a specific user account.
     */
    public function autoVerify(User $user)
    {
        $this->authorize('admin-only');

        if (!$user->id_photo) {
            return back()->withErrors("Cannot run OCR: {$user->name} has not uploaded an ID photo.");
        }

        $result = $this->verifier->verify($user);

        $user->update([
            'id_verification_status' => $result['status'],
            'id_verification_score'  => $result['score'],
            'id_verification_notes'  => $result['notes'],
            'id_verified_at'         => $result['status'] === 'verified' ? now() : null,
        ]);

        if ($result['status'] === 'verified') {
            return back()->with('success', "Account for {$user->name} was successfully auto-approved! (Score: {$result['score']}%)");
        }

        return back()->with('success', "OCR verification completed for {$user->name}. Result: {$result['status']} (Score: {$result['score']}%). Details: {$result['notes']}");
    }

    /**
     * Admin: Trigger batch auto-verification on all pending tourist accounts with ID photos.
     */
    public function batchAutoVerify()
    {
        $this->authorize('admin-only');

        $pendingUsers = User::where('role', 'tourist')
            ->where('id_verification_status', 'pending')
            ->whereNotNull('id_photo')
            ->get();

        if ($pendingUsers->isEmpty()) {
            return back()->with('success', 'No pending accounts with uploaded ID photos found to verify.');
        }

        $approvedCount = 0;
        $scannedCount = 0;

        foreach ($pendingUsers as $user) {
            $scannedCount++;
            $result = $this->verifier->verify($user);
            $isVerified = ($result['status'] === 'verified');

            $user->update([
                'id_verification_status' => $result['status'],
                'id_verification_score'  => $result['score'],
                'id_verification_notes'  => $result['notes'],
                'id_verified_at'         => $isVerified ? now() : null,
            ]);

            if ($isVerified) {
                $approvedCount++;
            }
        }

        return back()->with('success', "Batch OCR verification completed: {$approvedCount} of {$scannedCount} accounts auto-approved.");
    }
}

