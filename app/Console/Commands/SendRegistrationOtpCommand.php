<?php

namespace App\Console\Commands;

use App\Mail\RegistrationOtpMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRegistrationOtpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:send-otp {email : The recipient email address} {otp : The 6-digit OTP code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a registration OTP email asynchronously in the background';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = strtolower(trim((string) $this->argument('email')));
        $otp = (int) $this->argument('otp');

        $t0 = microtime(true);

        try {
            Mail::to($email)->send(new RegistrationOtpMail($otp));
            $t1 = microtime(true);

            Log::info(sprintf(
                "[Async OTP Sent] Delivered to %s in %.2f ms",
                $email,
                ($t1 - $t0) * 1000
            ));

            return self::SUCCESS;
        } catch (\Throwable $e) {
            Log::error("[Async OTP Error] Failed delivering to {$email}: " . $e->getMessage(), [
                'exception' => $e,
            ]);

            return self::FAILURE;
        }
    }
}
