<?php

use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Config;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;



beforeEach(function () {
    session()->flush();
    $this->requester = User::factory()->create();
    $this->userRequested = User::factory()->create();
});

it('require authentication', function () {
    put(route('friends.update', $this->userRequested))
        ->assertRedirect(route('login'));
});
it('can accept a friend request', function () {
    session()->flush();

    Friend::factory()->create([
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);
    actingAs($this->userRequested)
        ->put(route('friends.update', $this->requester))
        ->assertStatus(302)
        ->assertSessionHas('flash.banner', 'Friend request accepted successfully')
        ->assertSessionHas('flash.bannerStyle', 'success');

    $this->assertDatabaseMissing('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);

    $this->assertDatabaseHas('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::ACCEPTED
    ]);
});
it('should not accept a friend request if already friends', function () {
    Friend::factory()->create([
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::ACCEPTED
    ]);
    $this->assertDatabaseHas('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::ACCEPTED
    ]);

    actingAs($this->userRequested)
        ->put(route('friends.update', $this->requester))
        ->assertStatus(302)
        ->assertSessionHas('flash.banner', 'Failed to accept the friend request')
        ->assertSessionHas('flash.bannerStyle', 'danger');
    
    $this->assertDatabaseHas('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::ACCEPTED,
    ]);
});
it('should not accept a friend request if no pending request', function () {
    
    $this->assertDatabaseMissing('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);

    
    actingAs($this->userRequested)
        ->put(route('friends.update', $this->requester))
        ->assertStatus(302)
        ->assertSessionHas('flash.banner', 'Failed to accept the friend request')
        ->assertSessionHas('flash.bannerStyle', 'danger');

    $this->assertDatabaseMissing('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::ACCEPTED
    ]);
});