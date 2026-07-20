<?php

namespace App\Listeners;

use App\Events\UserForgotPassword;
use App\Mail\ResetPasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;
    public int $backoff = 5;
    /**
     * Handle the event.
     */
    public function handle(UserForgotPassword $event): void
    {
        Mail::to($event->user->email)
            ->send(new ResetPasswordMail($event->user, $event->token, $event->resetLink));
    }
}
