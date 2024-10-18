<?php

namespace App\Listeners;

use App\Events\FriendRequestIgnored;
use App\Notifications\FriendRequestIgnoredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class FriendRequestIgnoredListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 5;
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
    public function failed(FriendRequestIgnored $event, Throwable $exception): void
    {
        // Log the failure or perform any other necessary actions
        Log::error('Friend request ignore notification failed to send', [
            'sender' => $event->sender->id,
            'recipient' => $event->recipient->id,
            'exception' => $exception->getMessage(),
        ]);
    }
}
