<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Mail\OrderStatusChangedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;


class SendOrderStatusEmail implements ShouldQueue
{
    public int $tries = 3;
    public int $backoff = 5;
    /**
     * Handle the event.
     */
    public function handle(OrderStatusUpdated $event): void
    {
        $order = $event->order->load('items.product');

        Mail::to($order->email)
            ->send(new OrderStatusChangedMail($order));
    }
}
