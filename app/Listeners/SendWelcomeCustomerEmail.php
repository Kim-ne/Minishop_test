<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\CustomerRegistered;
use App\Mail\WelcomeCustomerMail;

class SendWelcomeCustomerEmail implements ShouldQueue
{
    public int $tries = 3;
    public int $backoff = 5;
    /**
     * Handle the event.
     */
    public function handle(CustomerRegistered $event): void
    {
        Mail::to($event->customer->email)
            ->send(new WelcomeCustomerMail($event->customer));
    }
}
