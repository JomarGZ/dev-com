<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;
beforeEach(function () {
    $this->user = User::factory()->create();
    $this->notificationAttr = [
        'id'                => '12e0455d-83b1-4a3b-8fea-c5c244c41e88',
        'type'              => 'App\Notifications\FriendRequestSentNotification',
        'notifiable_type'   => 'user',
        'notifiable_id'     => $this->user->id,
        'data'              => '{"info":{"profile_photo_url":"http:\/\/dev-com.test\/storage\/images\/default-avatar.jpg","name":"Jomar Godinez","message":"Accepted your friend request","link":"http:\/\/dev-com.test\/profiles\/11\/jomar-godinez"}}',
        'read_at'           => null
    ];
});

it('require authentication', function () {
    $notification = $this->user->notifications()->create($this->notificationAttr);
    put(route('notifications.update', $notification->id))
        ->assertRedirect(route('login'));
});
it('allow single notification to mark as read', function () {
    $notification = $this->user->notifications()->create($this->notificationAttr);
    actingAs($this->user)
        ->put(route('notifications.update', $notification->id))
        ->assertStatus(200);
    
    $this->assertNotNull($this->user->notifications()->find($notification->id)->read_at);
});