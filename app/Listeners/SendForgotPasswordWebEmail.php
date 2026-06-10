<?php

namespace App\Listeners;

use App\Events\UserForgotPasswordWeb;
use App\Mail\UserResetPasswordWebMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordWebEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;
    public int $backoff = 5;

    /**
     * Handle the event.
     */
    public function handle(UserForgotPasswordWeb $event): void
    {
        Mail::to($event->user->email)
            ->send(new UserResetPasswordWebMail($event->user, $event->token));
    }
}
