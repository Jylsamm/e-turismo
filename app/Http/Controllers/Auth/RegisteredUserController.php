<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\VerifyUserIdentityJob;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $isSchoolId = $request->input('id_type') === 'School ID';

        // ID types that do NOT print/require DOB — must match the JS ID_TYPES_WITH_DOB set
        $dobExemptTypes = ['School ID', 'Company ID', 'Barangay ID'];
        $requiresDob    = !in_array($request->input('id_type'), $dobExemptTypes);

        // Fix 5: DOB conditionally required based on ID type with exact 12+ birthday boundary
        $minAgeBoundary = \Illuminate\Support\Carbon::today()->subYears(12)->toDateString();
        $dobRules = $requiresDob
            ? ['required', 'date', 'before_or_equal:' . $minAgeBoundary]
            : ['nullable', 'date'];

        try {
            $request->validate([
                'first_name'     => ['required', 'string', 'max:100'],
                'last_name'      => ['required', 'string', 'max:100'],
                'middle_initial' => ['nullable', 'string', 'max:10'],
                'suffix'         => ['nullable', 'string', 'max:20'],
                'email'          => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    'regex:/^[a-zA-Z0-9._%\+\-]+@gmail\.com$/i',
                    'unique:' . User::class,
                ],
                'password'       => ['required', 'confirmed', Rules\Password::defaults()],
                'classification' => ['required', 'string', 'in:Local,Domestic,Foreign'],
                'gender'         => ['required', 'string', 'in:Male,Female'],
                'contact'        => ['required', 'string', 'max:20', 'regex:/^[0-9\+\-\s()]{7,20}$/'],
                'id_type'        => ['required', 'string', 'max:50'],
                // School ID submits school_name; all others submit id_number
                'school_name'    => $isSchoolId ? ['required', 'string', 'max:150'] : ['nullable'],
                'id_number'      => !$isSchoolId ? ['required', 'string', 'max:50'] : ['nullable'],
                'dob'            => $dobRules,
                'id_photo'       => [
                    function ($attribute, $value, $fail) use ($request) {
                        if (!$request->hasFile('id_photo') && !$request->filled('id_photo_base64')) {
                            $fail('Please capture or upload your ID photo.');
                        }
                    }
                ],
            ], [
                'contact.required'    => 'Please enter your phone number to proceed.',
                'contact.regex'       => 'Please enter a valid phone number (digits only, e.g. 09XXXXXXXXX).',
                'email.regex'         => 'The email address must be a valid @gmail.com address.',
                'school_name.required'=> 'Please enter your school name.',
                'id_number.required'  => 'The ID number field is required.',
                // Fix 4: Clear 12+ error message
                'dob.before'          => 'You must be at least 12 years old to register.',
            ]);

            // Verify the email matches the one confirmed via OTP in this session or cache marker
            if (!app()->environment('testing')) {
                $reqEmail    = strtolower(trim($request->email));
                $sessEmail   = strtolower(trim((string) session('otp_verified_email')));
                $cacheMarker = Cache::get('otp_verified_marker:' . $reqEmail);

                if ($reqEmail !== $sessEmail && !$cacheMarker) {
                    throw ValidationException::withMessages([
                        'email' => 'Please verify your Gmail address with the one-time code sent to your email.',
                    ]);
                }
            }
        } catch (ValidationException $e) {
            Log::warning('[Registration Validation Failed]', [
                'email' => $request->email,
                'errors' => $e->errors(),
                'session_otp_email' => session('otp_verified_email'),
                'has_file' => $request->hasFile('id_photo'),
                'has_base64' => $request->filled('id_photo_base64'),
            ]);
            throw $e;
        }

        // Store uploaded or base64 ID photo
        $idPhotoPath = null;
        if ($request->hasFile('id_photo')) {
            $file        = $request->file('id_photo');
            $idPhotoPath = $file->storeAs(
                'id_photos',
                time() . '_' . strtolower($file->getClientOriginalName()),
                'public'
            );
        } elseif ($request->filled('id_photo_base64')) {
            $base64Data = $request->input('id_photo_base64');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Data)) {
                $data = substr($base64Data, strpos($base64Data, ',') + 1);
                $decoded = base64_decode($data);
                $filename = time() . '_captured_id.jpg';
                Storage::disk('public')->put('id_photos/' . $filename, $decoded);
                $idPhotoPath = 'id_photos/' . $filename;
            }
        }

        // Compose full name: First [M.I.] Last [Suffix]
        $nameParts = array_filter([
            trim($request->first_name),
            $request->middle_initial ? strtoupper(rtrim($request->middle_initial, '.')) . '.' : null,
            trim($request->last_name),
            $request->suffix ? trim($request->suffix) : null,
        ]);
        $fullName = implode(' ', $nameParts);

        // Fix 6: Wrap ONLY the user insert in a DB transaction.
        // The job dispatch and event fire happen OUTSIDE the transaction so that
        // a dispatch/event failure can never roll back the user row.
        try {
            $user = DB::transaction(function () use (
                $request, $fullName, $isSchoolId, $idPhotoPath
            ) {
                $newUser = User::create([
                    'name'            => $fullName,
                    'last_name'       => trim($request->last_name),
                    'middle_initial'  => $request->middle_initial
                        ? strtoupper(rtrim($request->middle_initial, '.')) . '.'
                        : null,
                    'suffix'          => $request->suffix ? trim($request->suffix) : null,
                    'email'           => $request->email,
                    'password'        => Hash::make($request->password),
                    'role'            => 'tourist',
                    'contact'         => $request->contact,
                    'classification'  => $request->classification,
                    'gender'          => $request->gender,
                    'id_type'         => $request->id_type,
                    'id_number'       => $isSchoolId ? $request->school_name : $request->id_number,
                    'dob'             => $request->dob ?: null,
                    'id_photo'        => $idPhotoPath,
                    'email_verified_at'               => now(),
                    // Start as 'pending' identity verification
                    'id_verification_status'          => 'pending',
                    'ready_to_complete_requirements'  => true,
                ]);

                Log::info("[Registration] User created successfully: id={$newUser->id}, email={$newUser->email}");

                return $newUser;
            });
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000 || str_contains($e->getMessage(), '1062')) {
                Log::warning('[Registration] Duplicate DB entry blocked: ' . $request->email);
                throw ValidationException::withMessages([
                    'email' => 'This email address is already registered.',
                ]);
            }
            Log::error('[Registration] Database error creating user row: ' . $e->getMessage(), [
                'email'     => $request->email,
                'exception' => $e,
            ]);
            throw $e;
        } catch (\Throwable $e) {
            Log::error('[Registration] Failed to create user row: ' . $e->getMessage(), [
                'email'     => $request->email,
                'exception' => $e,
            ]);
            throw $e;
        }

        // Fire Laravel's Registered event outside the transaction
        // (default email verification notification is a no-op — see User::sendEmailVerificationNotification)
        try {
            event(new Registered($user));
        } catch (\Throwable $e) {
            Log::warning('[Registration] Registered event listener threw an exception: ' . $e->getMessage());
            // Non-fatal — user row already exists, continue
        }

        // Log the user in before dispatching the job so the session is established
        Auth::login($user);

        // Fix 2: Dispatch OCR job AFTER login so the user is already saved to DB.
        // With QUEUE_CONNECTION=sync (default for XAMPP), this still runs inline
        // but exceptions from OCR can no longer prevent the user account from existing.
        try {
            VerifyUserIdentityJob::dispatch($user);
        } catch (\Throwable $e) {
            // Fix 6: OCR dispatch failure must never prevent the user from reaching the dashboard
            Log::error('[Registration] Failed to dispatch VerifyUserIdentityJob: ' . $e->getMessage(), [
                'user_id'   => $user->id,
                'exception' => $e,
            ]);
            // Gracefully fall back to 'pending' so admin can manually review
            $user->update([
                'id_verification_status' => 'pending',
                'id_verification_notes'  => 'OCR_DISPATCH_FAILED: ' . $e->getMessage(),
            ]);
        }

        return redirect()->intended(route('dashboard'));
    }
}
