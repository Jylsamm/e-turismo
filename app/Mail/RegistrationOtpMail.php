<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationOtpMail extends Mailable
{
    use SerializesModels;

    public int $otp;

    public function __construct(int $otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Your E-Turismo Verification Code')
            ->view('emails.registration-otp')
            ->with([
                'otp' => $this->otp,
            ]);
    }
}
