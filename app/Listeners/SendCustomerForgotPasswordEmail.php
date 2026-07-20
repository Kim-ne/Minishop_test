<?php

namespace App\Listeners;

use App\Events\CustomerForgotPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerResetPasswordMail;

class SendCustomerForgotPasswordEmail implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(CustomerForgotPassword $event): void
    {
        Mail::to($event->customer->email)
            ->send(new CustomerResetPasswordMail($event->customer, $event->token));
    }
}
