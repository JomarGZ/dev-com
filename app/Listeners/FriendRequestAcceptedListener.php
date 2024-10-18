<?php

namespace App\Listeners;

use App\Events\FriendRequestAccepted;
use App\Notifications\FriendRequestAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class FriendRequestAcceptedListener implements ShouldQueue
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
    public function handle(FriendRequestAccepted $event): void
    {
        $event->sender->notify(new FriendRequestAcceptedNotification($event->recipient));
    }
    public function failed(FriendRequestAccepted $event, Throwable $exception): void
    {
        // Log the failure or perform any other necessary actions
        Log::error('Friend request acceptance notification failed to send', [
            'sender' => $event->sender->id,
            'recipient' => $event->recipient->id,
            'exception' => $exception->getMessage(),
        ]);
    }
}
