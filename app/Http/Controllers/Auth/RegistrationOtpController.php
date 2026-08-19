<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegistrationOtpController extends Controller
{
    public function sendCode(Request $request)
    {
<<<<<<< Updated upstream
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
=======
        $tStart = microtime(true);

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%\+\-]+@gmail\.com$/i'],
>>>>>>> Stashed changes
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        $email = strtolower(trim($request->email));

        if (User::where('email', $email)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'This Gmail is already registered.'], 422);
        }

<<<<<<< Updated upstream
        $throttleKey = 'registration-otp-send:' . $request->ip();
        if (RateLimiterFacade::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiterFacade::availableIn($throttleKey);
=======
        $throttleKey = 'registration-otp-send:' . $email . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
>>>>>>> Stashed changes
            return response()->json(['status' => 'error', 'message' => "Too many requests. Try again in {$seconds} seconds."], 429);
        }

        RateLimiter::hit($throttleKey, 60);

        $otp = random_int(100000, 999999);
        $cacheKey = 'registration-otp:' . $email;

        // High-speed HMAC SHA-256 computation (< 0.01 ms vs Bcrypt ~250 ms)
        $otpHash = hash_hmac('sha256', (string) $otp, config('app.key'));

        Cache::put($cacheKey, [
            'hash' => $otpHash,
            'email' => $email,
            'sent_at' => now()->timestamp,
        ], now()->addMinutes(10));

<<<<<<< Updated upstream
        try {
            Mail::to($email)->send(new RegistrationOtpMail($otp));
=======
        // Deliver OTP directly via Gmail SMTP with robust error handling
        try {
            Mail::to($email)->send(new RegistrationOtpMail($otp));
            $duration = (microtime(true) - $tStart) * 1000;
            Log::info(sprintf("[OTP Sent Successfully] Code %s delivered to %s in %.2f ms", $otp, $email, $duration));
>>>>>>> Stashed changes
        } catch (\Throwable $e) {
            Log::error("[OTP Send Failed] Error delivering to {$email}: " . $e->getMessage(), [
                'exception' => $e,
            ]);
            return response()->json(['status' => 'error', 'message' => 'Failed to send verification code to your Gmail. Please try again in a few moments.'], 500);
        }

        session()->forget('otp_verified_email');

        return response()->json([
            'status' => 'ok',
            'message' => 'A 6-digit code was sent to your Gmail address.',
            'cooldown' => 60
        ]);
    }

    public function verifyCode(Request $request)
    {
<<<<<<< Updated upstream
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
=======
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%\+\-]+@gmail\.com$/i'],
>>>>>>> Stashed changes
            'code' => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        $email = strtolower(trim($request->email));
        $cacheKey = 'registration-otp:' . $email;
        $otpData = Cache::get($cacheKey);

        if (! $otpData) {
            return response()->json(['status' => 'error', 'message' => 'No active verification code was found. Please request a new code.'], 422);
        }

<<<<<<< Updated upstream
        $verifyKey = 'registration-otp-verify:' . $request->ip();
        if (RateLimiterFacade::tooManyAttempts($verifyKey, 5)) {
            $seconds = RateLimiterFacade::availableIn($verifyKey);
=======
        $verifyKey = 'registration-otp-verify:' . $email . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($verifyKey, 5)) {
            $seconds = RateLimiter::availableIn($verifyKey);
>>>>>>> Stashed changes
            return response()->json(['status' => 'error', 'message' => "Too many attempts. Try again in {$seconds} seconds."], 429);
        }

        $inputCode = (string) $request->code;
        $storedHash = (string) ($otpData['hash'] ?? '');

        $isValid = false;

        // 1. High-speed constant-time HMAC SHA-256 verification (< 0.001 ms)
        $expectedHmac = hash_hmac('sha256', $inputCode, config('app.key'));
        if (hash_equals($storedHash, $expectedHmac)) {
            $isValid = true;
        } elseif (str_starts_with($storedHash, '$2y$') || str_starts_with($storedHash, '$2a$')) {
            // Legacy Bcrypt fallback
            $isValid = Hash::check($inputCode, $storedHash);
        }

        if (! $isValid) {
            RateLimiter::hit($verifyKey, 60);
            return response()->json(['status' => 'error', 'message' => 'Invalid code, please try again.'], 422);
        }

        Cache::forget($cacheKey);
        RateLimiter::clear($verifyKey);

        session(['otp_verified_email' => $email]);

        return response()->json(['status' => 'ok', 'message' => 'Email verified successfully.']);
    }

    /**
     * Resolve the exact PHP CLI executable path across environments.
     */
    protected function getPhpBinary(): string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            if (file_exists('C:/xampp/php/php.exe')) {
                return 'C:/xampp/php/php.exe';
            }
            if (defined('PHP_BINDIR') && file_exists(PHP_BINDIR . DIRECTORY_SEPARATOR . 'php.exe')) {
                return PHP_BINDIR . DIRECTORY_SEPARATOR . 'php.exe';
            }
            if (defined('PHP_BINARY') && str_ends_with(strtolower(PHP_BINARY), 'php.exe') && file_exists(PHP_BINARY)) {
                return PHP_BINARY;
            }
            return 'php';
        }

        if (defined('PHP_BINARY') && file_exists(PHP_BINARY)) {
            return PHP_BINARY;
        }

        return 'php';
    }
}
