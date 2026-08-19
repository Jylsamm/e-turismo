<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\VerifyUserIdentityJob;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

        // Fix 5: DOB conditionally required based on ID type
        // Fix 4: Backend 12+ age check — only applied when DOB is required
        $dobRules = $requiresDob
            ? ['required', 'date', 'before:' . now()->subYears(12)->toDateString()]
            : ['nullable', 'date'];

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
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i',
                'unique:' . User::class,
            ],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
            'classification' => ['required', 'string', 'in:Local,Domestic,Foreign'],
            'gender'         => ['required', 'string', 'in:Male,Female'],
            'id_type'        => ['required', 'string', 'max:50'],
            // School ID submits school_name; all others submit id_number
            'school_name'    => $isSchoolId ? ['required', 'string', 'max:150'] : ['nullable'],
            'id_number'      => !$isSchoolId ? ['required', 'string', 'max:50'] : ['nullable'],
            'dob'            => $dobRules,
            // Composite front+back JPEG can reach ~10 MB at native phone resolution; allow up to 20 MB.
            'id_photo'       => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,gif,tiff,bmp', 'max:20480'],
        ], [
            'email.regex'         => 'The email address must be a valid @gmail.com address.',
            'school_name.required'=> 'Please enter your school name.',
            'id_number.required'  => 'The ID number field is required.',
            // Fix 4: Clear 12+ error message
            'dob.before'          => 'You must be at least 12 years old to register.',
        ]);

        // Verify the email matches the one confirmed via OTP in this session
        if (!app()->environment('testing') && strtolower($request->email) !== strtolower(session('otp_verified_email'))) {
            throw ValidationException::withMessages([
                'email' => 'Please verify your Gmail address with the one-time code sent to your email.',
            ]);
        }

        // Store uploaded ID photo
        $idPhotoPath = null;
        if ($request->hasFile('id_photo')) {
            $file        = $request->file('id_photo');
            $idPhotoPath = $file->storeAs(
                'id_photos',
                time() . '_' . strtolower($file->getClientOriginalName()),
                'public'
            );
        }

        // Compose full name: First [M.I.] Last [Suffix]
        $firstName = trim($request->first_name);
        $middleInitial = $request->middle_initial ? strtoupper(rtrim($request->middle_initial, '.')) . '.' : null;
        if ($middleInitial && in_array(strtoupper(rtrim($middleInitial, '.')), ['N/A', 'NA', 'NONE', 'NOT APPLICABLE', 'NULL'])) {
            $middleInitial = null;
        }

        $lastName = trim($request->last_name);
        $suffix = $request->suffix ? trim($request->suffix) : null;
        if ($suffix && in_array(strtoupper($suffix), ['N/A', 'NA', 'NONE', 'NOT APPLICABLE', 'NULL'])) {
            $suffix = null;
        }

        if ($middleInitial) {
            $rawMi = rtrim($middleInitial, '.');
            $firstName = preg_replace('/\s+' . preg_quote($rawMi, '/') . '\.?$/i', '', $firstName);
        }
        if ($lastName) {
            $firstName = preg_replace('/\s+' . preg_quote($lastName, '/') . '$/i', '', $firstName);
        }

        $nameParts = array_filter([$firstName, $middleInitial, $lastName, $suffix]);
        $fullName = implode(' ', $nameParts);

        // Fix 6: Wrap ONLY the user insert in a DB transaction.
        // The job dispatch and event fire happen OUTSIDE the transaction so that
        // a dispatch/event failure can never roll back the user row.
        try {
            $user = DB::transaction(function () use (
                $request, $fullName, $middleInitial, $suffix, $isSchoolId, $idPhotoPath
            ) {
                $newUser = User::create([
                    'name'            => $fullName,
                    'last_name'       => trim($request->last_name),
                    'middle_initial'  => $middleInitial,
                    'suffix'          => $suffix,
                    'email'           => $request->email,
                    'password'        => Hash::make($request->password),
                    'role'            => 'tourist',
                    'classification'  => $request->classification,
                    'gender'          => $request->gender,
                    'id_type'         => $request->id_type,
                    'id_number'       => $isSchoolId ? $request->school_name : $request->id_number,
                    'dob'             => $request->dob ?: null,
                    'id_photo'        => $idPhotoPath,
                    'email_verified_at'               => now(),
                    // Fix 2: Start as 'processing' — job will update this after OCR
                    'id_verification_status'          => 'processing',
                    'ready_to_complete_requirements'  => true,
                ]);

                Log::info("[Registration] User created successfully: id={$newUser->id}, email={$newUser->email}");

                return $newUser;
            });
        } catch (\Throwable $e) {
            // Fix 6: Log DB insert failures explicitly — never silently fail
            Log::error('[Registration] Failed to create user row: ' . $e->getMessage(), [
                'email'     => $request->email,
                'exception' => $e,
            ]);
            throw $e; // Re-throw so Laravel returns a proper 500 / shows the error
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

        // Dispatch OCR job asynchronously using afterResponse() so the tourist receives an immediate
        // redirect to the dashboard without waiting for external OCR API latency
        try {
            VerifyUserIdentityJob::dispatch($user)->afterResponse();
        } catch (\Throwable $e) {
            Log::error('[Registration] Failed to dispatch VerifyUserIdentityJob: ' . $e->getMessage(), [
                'user_id'   => $user->id,
                'exception' => $e,
            ]);
            $user->update([
                'id_verification_status' => 'pending',
                'id_verification_notes'  => 'OCR_DISPATCH_FAILED: ' . $e->getMessage(),
            ]);
        }

        return redirect()->intended(route('dashboard'));
    }
}
