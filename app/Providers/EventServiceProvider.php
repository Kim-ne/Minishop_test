<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Listeners\SendWelcomeEmail;
use App\Listeners\SendOrderConfirmationEmail;
use App\Listeners\SendWelcomeCustomerEmail;
use App\Listeners\SendForgotPasswordEmail;
use App\Listeners\SendUserEmailVerificationEmail;
use App\Listeners\SendCustomerForgotPasswordEmail;
use App\Listeners\SendCustomerVerificationEmail;
use App\Events\UserRegistered;
use App\Events\CustomerRegistered;
use App\Events\OrderPlaced;
use App\Events\OrderStatusUpdated;
use App\Events\UserForgotPassword;
use App\Events\UserEmailVerification;
use App\Events\CustomerForgotPassword;
use App\Events\CustomerEmailVerification;

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
        ],

        // Register OrderStatusUpdated
        OrderStatusUpdated::class => [
            SendOrderStatusEmail::class
        ],

        // Register UserForgotPassword
        UserForgotPassword::class => [
            SendForgotPasswordEmail::class
        ],

        // Register UserVerified
        UserEmailVerification::class => [
            SendUserEmailVerificationEmail::class
        ],

        // Register CustomerForgotPassword
        CustomerForgotPassword::class => [
            SendCustomerForgotPasswordEmail::class
        ],

        // Register CustomerVerified
        CustomerEmailVerification::class => [
            SendCustomerVerificationEmail::class
        ]

    ];

}
