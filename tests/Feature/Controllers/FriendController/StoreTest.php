<?php

use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Config;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;


beforeEach(function () {
    session()->flush();
    $this->requester = User::factory()->create();
    $this->userRequested = User::factory()->create();
});

it('required authentication', function () {
    post(route('friends.store', $this->requester))
        ->assertRedirect(route('login'));
});

it('can send friend request', function () {
    actingAs($this->requester)
        ->post(route('friends.store', $this->userRequested))
        ->assertStatus(302)
        ->assertSessionHas('message', 'Friend request sent successfully');

    $this->assertDatabaseHas('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);
});

it('should not send friend request to user that already friends', function () {
   
    Friend::factory()->create([
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::ACCEPTED
    ]);
    actingAs($this->requester)
        ->post(route('friends.store', $this->userRequested))
        ->assertStatus(status: 500);
       

    $this->assertDatabaseMissing('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);
});

it('should not send friend request to user that already sent friend request', function () {
   
    Friend::factory()->create([
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);
    actingAs($this->requester)
        ->post(route('friends.store', $this->userRequested))
        ->assertStatus(status: 500);
 

    $this->assertDatabaseCount('friends', 1);
});

it('should not send friend request to user that already has pending friend request from', function () {
   
    Friend::factory()->create([
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);
    actingAs($this->requester)
        ->post(route('friends.store', $this->userRequested))
        ->assertStatus(status: 500);

    $this->assertDatabaseCount('friends', 1);
});
