<?php

namespace App\Listeners;

use App\Events\UserEmailVerification;
use App\Mail\UserEmailVerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendUserEmailVerificationEmail implements ShouldQueue
{
    public int $tries = 3;
    public int $backoff = 5;
    /**
     * Handle the event.
     */
    public function handle(UserEmailVerification $event): void
    {
        $user = $event->user;

        $verificationUrl = URL::temporarySignedRoute(
            $event->verificationRoute,
            now()->addMinutes(60),
                ['id' => $user->id,
                'hash' => sha1($user->email),
                ]
        );

        Mail::to($user->email)
            ->send(new UserEmailVerificationMail($user, $verificationUrl));

    }
}
