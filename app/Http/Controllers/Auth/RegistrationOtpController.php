<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationOtpMail;
use App\Models\User;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter as RateLimiterFacade;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegistrationOtpController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
        ]);

        $email = strtolower(trim($request->email));

        if (User::where('email', $email)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'This Gmail is already registered.'], 422);
        }

        $throttleKey = 'registration-otp-send:' . $request->ip();
        if (RateLimiterFacade::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiterFacade::availableIn($throttleKey);
            return response()->json(['status' => 'error', 'message' => "Too many requests. Try again in {$seconds} seconds."], 429);
        }

        RateLimiterFacade::hit($throttleKey, 60);

        $otp = random_int(100000, 999999);
        $cacheKey = 'registration-otp:' . $email;

        Cache::put($cacheKey, [
            'hash' => Hash::make((string) $otp),
            'email' => $email,
            'sent_at' => now()->timestamp,
        ], now()->addMinutes(10));

        Mail::to($email)->send(new RegistrationOtpMail($otp));

        session()->forget('otp_verified_email');

        return response()->json(['status' => 'ok', 'message' => 'A 6-digit code was sent to your Gmail address.', 'cooldown' => 60]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
            'code' => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/'],
        ]);

        $email = strtolower(trim($request->email));
        $cacheKey = 'registration-otp:' . $email;
        $otpData = Cache::get($cacheKey);

        if (! $otpData) {
            return response()->json(['status' => 'error', 'message' => 'No active verification code was found. Please request a new code.'], 422);
        }

        $verifyKey = 'registration-otp-verify:' . $request->ip();
        if (RateLimiterFacade::tooManyAttempts($verifyKey, 5)) {
            $seconds = RateLimiterFacade::availableIn($verifyKey);
            return response()->json(['status' => 'error', 'message' => "Too many attempts. Try again in {$seconds} seconds."], 429);
        }

        if (! Hash::check($request->code, $otpData['hash'])) {
            RateLimiterFacade::hit($verifyKey, 60);
            return response()->json(['status' => 'error', 'message' => 'Invalid code, please try again.'], 422);
        }

        Cache::forget($cacheKey);
        RateLimiterFacade::clear($verifyKey);

        session(['otp_verified_email' => $email]);

        return response()->json(['status' => 'ok', 'message' => 'Email verified successfully.']);
    }
}
