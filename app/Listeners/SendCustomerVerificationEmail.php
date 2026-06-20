<?php

namespace App\Listeners;

use App\Events\CustomerEmailVerification;
use App\Mail\CustomerEmailVerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendCustomerVerificationEmail implements ShouldQueue
{
    public int $tries = 3;
    public int $backoff = 5;
    /**
     * Handle the event.
     */
    public function handle(CustomerEmailVerification $event): void
    {
        $customer = $event->customer;

        $verificationUrl = URL::temporarySignedRoute(
            'api.v1.customer.email.verify',
            now()->addMinutes(60),
                [
                'id' => $customer->id,
                'hash' => sha1($customer->email),
                ]
        );

        Mail::to($customer->email)
            ->send(new CustomerEmailVerificationMail($customer, $verificationUrl));

    }
}
