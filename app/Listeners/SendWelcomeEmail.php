<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    public int $tries = 3;
    public int $backoff = 5;

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        Mail::to($event->user->email)
            ->send(new WelcomeMail($event->user));
    }
}
