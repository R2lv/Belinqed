<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/* For user e-mail verification*/
use App\Mail\EmailValidationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\UserToken;

class SendVerificationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;


        $userToken = UserToken::query()->create([
        	'user_id'=>$user->id,
			'token'=>str_random(11),
			'type'=>'email',
			'user_type'=>$user instanceof User ? 'normal' : 'company'
		]);

        Mail::to($user->email)->send(new EmailValidationMail($user,$userToken));

    }
}
