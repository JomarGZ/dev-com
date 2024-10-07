<?php

namespace App\Providers;

use App\Events\FriendRequestAccepted;
use App\Events\FriendRequestIgnored;
use App\Events\FriendRequestSent;
use App\Events\Unfriended;
use App\Listeners\FriendRequestAcceptedListener;
use App\Listeners\FriendRequestIgnoredListener;
use App\Listeners\FriendRequestSentListener;
use App\Listeners\UnfriendedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        FriendRequestSent::class => [
            FriendRequestSentListener::class
        ],
        FriendRequestIgnored::class => [
            FriendRequestIgnoredListener::class
        ],
        FriendRequestAccepted::class => [
            FriendRequestAcceptedListener::class
        ],
        Unfriended::class => [
            UnfriendedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
