<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerified extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->name = $user->name;
        $this->email = $user->email;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email verification') // todo translate
        ->from('no-reply@belinqed.com')
            ->markdown('emails.email-verified')
            ->with([
                'name'=>$this->name,
                'email'=>$this->email,
                'website'=>env('APP_URL')
            ]);
    }
}
