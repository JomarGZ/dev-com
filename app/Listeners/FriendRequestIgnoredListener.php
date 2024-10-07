<?php

namespace App\Listeners;

use App\Notifications\FriendRequestIgnoredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FriendRequestIgnoredListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->sender->notify(new FriendRequestIgnoredNotification($event->recipient));
    }
}
