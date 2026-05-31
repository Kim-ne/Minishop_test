<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Listeners\SendWelcomeEmail;
use App\Listeners\SendOrderConfirmationEmail;
use App\Listeners\SendWelcomeCustomerEmail;
use App\Events\UserRegistered;
use App\Events\CustomerRegistered;
use App\Events\OrderPlaced;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Register UserRegistered
        UserRegistered::class => [
            SendWelcomeEmail::class,
        ],

        // Register CustomerRegistered
        CustomerRegistered::class => [
            SendWelcomeCustomerEmail::class
        ],

        // Register OrderPlaced
        OrderPlaced::class => [
            SendOrderConfirmationEmail::class
        ]
    ];

}
