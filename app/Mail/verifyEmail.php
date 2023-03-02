<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class verifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function verifyEmail(Request $request)
    {
        // Find the user by verification token
        $user = User::where('verification_token', $request->input('token'))->firstOrFail();
    
        // Mark the user's email address as verified
        $user->email_verified_at = Carbon::now();
        $user->verification_token = null;
        $user->save();
    
        // Redirect to the login page
        return redirect('/login');
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     return $this->view('view.name');
    // }
}
