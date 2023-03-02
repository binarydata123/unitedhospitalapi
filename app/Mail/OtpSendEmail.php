<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpSendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $otp;
    public function __construct($otp)
    {
        //
        $this->otp= $otp;
    }

    public function content()
    {
        return new Content(
            view: 'verification.otpSendEmail',
            with: [
                'otp' => $this->otp,
            ],
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->content;
    }
}
