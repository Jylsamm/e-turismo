<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\IdentityVerificationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function __construct(private IdentityVerificationService $verifier)
    {
    }

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

        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'middle_initial' => ['nullable', 'string', 'max:10'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i',
                'unique:' . User::class
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'classification' => ['required', 'string', 'in:Local,Domestic,Foreign'],
            'id_type' => ['required', 'string', 'max:50'],
            // School ID submits school_name; all others submit id_number
            'school_name' => $isSchoolId ? ['required', 'string', 'max:150'] : ['nullable'],
            'id_number' => !$isSchoolId ? ['required', 'string', 'max:50'] : ['nullable'],
            'dob' => ['required', 'date', 'before:today'],
            // Composite front+back JPEG can reach ~10 MB at native phone resolution; allow up to 20 MB.
            'id_photo' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,gif,tiff,bmp', 'max:20480'],
        ], [
            'email.regex' => 'The email address must be a valid @gmail.com address.',
            'school_name.required' => 'Please enter your school name.',
            'id_number.required' => 'The ID number field is required.',
        ]);

        $idPhotoPath = null;
        if ($request->hasFile('id_photo')) {
            $file = $request->file('id_photo');
            $idPhotoPath = $file->storeAs('id_photos', time() . '_' . strtolower($file->getClientOriginalName()), 'public');
        }

        // Compose full name: First [M.I.] Last
        $nameParts = array_filter([
            trim($request->first_name),
            $request->middle_initial ? strtoupper(rtrim($request->middle_initial, '.')) . '.' : null,
            trim($request->last_name),
        ]);
        $fullName = implode(' ', $nameParts);

        $user = User::create([
            'name' => $fullName,
            'last_name' => trim($request->last_name),
            'middle_initial' => $request->middle_initial
                ? strtoupper(rtrim($request->middle_initial, '.')) . '.'
                : null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'tourist',
            'classification' => $request->classification,
            'id_type' => $request->id_type,
            // For School ID, store the school name as id_number
            'id_number' => $isSchoolId ? $request->school_name : $request->id_number,
            'dob' => $request->dob,
            'id_photo' => $idPhotoPath,
            'id_verification_status' => 'unverified',
            'ready_to_complete_requirements' => true,
        ]);

        // Fire Laravel's Registered event → sends email verification link
        event(new Registered($user));

        // Auto-run the identity verification engine immediately
        $result = $this->verifier->verify($user);
        $user->update([
            'id_verification_status' => $result['status'],
            'id_verification_score' => $result['score'],
            'id_verification_notes' => $result['notes'],
            'id_verified_at' => $result['status'] === 'verified' ? now() : null,
        ]);

        Auth::login($user);

        // Redirect to email verification notice (Laravel built-in)
        return redirect()->intended(route('verification.notice'));
    }
}
