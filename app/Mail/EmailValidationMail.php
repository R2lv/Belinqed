<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailValidationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $id,$name,$email,$token,$user_type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$userToken)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->token = $userToken->token;
        $this->user_type = $userToken->user_type;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        return $this->view('emails.email-verification');

        return $this->subject('Email verification') // todo translate
                ->from('no-reply@belinqed.com')
                ->markdown('emails.email-verification')
                ->with([
                    'name'=>$this->name,
                    'email'=>$this->email,
                    'website'=>env('APP_URL'),
                    'url'=>env('APP_URL').'/verify/'.$this->id.'/'.$this->token.'/'.$this->user_type,
                ]);
    }
}
