<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderConfirmationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
class SendOrderConfirmationEmail implements ShouldQueue
{
    public int $tries = 3;
    public int $backoff = 5;

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order->load('items.product');

        Mail::to($order->email)
            ->send(new OrderConfirmationEmail($order));
    }
}
