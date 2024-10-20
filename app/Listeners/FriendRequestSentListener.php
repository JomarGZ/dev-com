<?php

namespace App\Listeners;

use App\Events\FriendRequestAccepted;
use App\Events\FriendRequestSent;
use App\Notifications\FriendRequestSentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class FriendRequestSentListener implements ShouldQueue
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
    public function handle(FriendRequestSent $event): void
    {
        $event->recipient->notify( new FriendRequestSentNotification($event->sender));
    }

    public function failed(FriendRequestSent $event, Throwable $exception): void
    {
        // Log the failure or perform any other necessary actions
        Log::error('Friend request sent notification failed to send', [
            'sender' => $event->sender->id,
            'recipient' => $event->recipient->id,
            'exception' => $exception->getMessage(),
        ]);
    }
}
