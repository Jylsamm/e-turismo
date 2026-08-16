<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Upload / Capture new ID photo from profile identity verification camera component.
     */
    public function uploadIdPhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'id_type'   => 'required|string|max:50',
            'id_number' => 'nullable|string|max:50',
            'id_photo'  => [
                function ($attribute, $value, $fail) use ($request) {
                    if (!$request->hasFile('id_photo') && !$request->filled('id_photo_base64')) {
                        $fail('Please capture or select an ID photo.');
                    }
                }
            ],
        ]);

        $user = $request->user();

        $idPhotoPath = null;
        if ($request->hasFile('id_photo')) {
            $file = $request->file('id_photo');
            $idPhotoPath = $file->storeAs('id_photos', time() . '_' . strtolower($file->getClientOriginalName()), 'public');
        } elseif ($request->filled('id_photo_base64')) {
            $base64Data = $request->input('id_photo_base64');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Data)) {
                $data = substr($base64Data, strpos($base64Data, ',') + 1);
                $decoded = base64_decode($data);
                $filename = time() . '_captured_profile_id.jpg';
                \Illuminate\Support\Facades\Storage::disk('public')->put('id_photos/' . $filename, $decoded);
                $idPhotoPath = 'id_photos/' . $filename;
            }
        }

        if ($idPhotoPath) {
            if ($user->id_photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->id_photo);
            }
            $user->id_photo = $idPhotoPath;
        }

        if ($request->filled('id_type'))   $user->id_type   = $request->id_type;
        if ($request->filled('id_number')) $user->id_number = $request->id_number;

        // Set status to pending for review
        $user->id_verification_status = 'pending';
        $user->id_verification_notes  = 'Submitted via profile camera capture, under review.';
        $user->is_manually_verified   = false;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'id-photo-uploaded');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
