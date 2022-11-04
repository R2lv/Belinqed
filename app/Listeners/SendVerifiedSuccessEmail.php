<?php

namespace App\Listeners;

use App\Events\UserVerified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/*
 * For user e-mail verification
 * */
use App\Mail\EmailVerified;
use Illuminate\Support\Facades\Mail;

class SendVerifiedSuccessEmail
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
     * @param  UserVerified  $event
     * @return void
     */
    public function handle(UserVerified $event)
    {
        Mail::to($event->user->email)->send(new EmailVerified($event->user));
    }
}
