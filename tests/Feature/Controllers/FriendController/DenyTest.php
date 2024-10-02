<?php

use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Config;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;


beforeEach(function () {
    session()->flush();
    $this->requester = User::factory()->create();
    $this->userRequested = User::factory()->create();
});

it('require authentication', function () {
    delete(route('friends.deny', $this->userRequested))
    ->assertRedirect(route('login'));
});

it('can deny a friend request', function () {
    Friend::factory()->create([
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);

    actingAs($this->userRequested)
        ->delete(route('friends.deny', $this->requester))
        ->assertStatus(302)
        ->assertSessionHas('flash.banner', 'Friend request denied successfully')
        ->assertSessionHas('flash.bannerStyle', 'success');


    $this->assertDatabaseMissing('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);

});
it('should not allow denying if there is no pending friend request', function () {
    
    $this->assertDatabaseMissing('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);
    actingAs($this->userRequested)
        ->delete(route('friends.deny', $this->requester))
        ->assertStatus(302)
        ->assertSessionHas('flash.banner', 'Friend request deny failed')
        ->assertSessionHas('flash.bannerStyle', 'danger');

    
});
it('should not allow denying if already friends', function () {
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
        ->delete(route('friends.deny', $this->requester))
        ->assertStatus(302)
        ->assertSessionHas('flash.banner', 'Friend request deny failed')
        ->assertSessionHas('flash.bannerStyle', 'danger');
    
    $this->assertDatabaseHas('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::ACCEPTED
    ]);
    
});
it('should not allow denying a request sent by the authenticated user', function () {
    Friend::factory()->create([
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);

    $this->assertDatabaseHas('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);

    actingAs($this->requester)
        ->delete(route('friends.deny', $this->userRequested))
        ->assertStatus(302)
        ->assertSessionHas('flash.banner', 'Friend request deny failed')
        ->assertSessionHas('flash.bannerStyle', 'danger');

    $this->assertDatabaseHas('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING
    ]);
});