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
    delete(route('friends.destroy', $this->requester))
        ->assertRedirect(route('login'));
});
it('can unfriend a friend user', function () {
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
    actingAs($this->requester)
        ->delete(route('friends.destroy', $this->userRequested))
        ->assertStatus(302)
        ->assertSessionHas('flash.banner', 'Successfully unfriended the user')
        ->assertSessionHas('flash.bannerStyle', 'success');
    
    $this->assertDatabaseMissing('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::ACCEPTED
    ]);
});
it('should not unfriend the user you are not friends', function () {

    $this->assertDatabaseCount('friends', 0);

    actingAs($this->requester)
        ->delete(route('friends.destroy', $this->userRequested))
        ->assertStatus(302)
        ->assertSessionHas('flash.banner', 'Failed to unfriend the user')
        ->assertSessionHas('flash.bannerStyle', 'danger');

});
it('should not unfriend the user that is still in pending request', function () {

    Friend::factory()->create([
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING,
    ]);

    $this->assertDatabaseHas('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING,
    ]);

    actingAs($this->requester)
        ->delete(route('friends.destroy', $this->userRequested))
        ->assertStatus(302)
        ->assertSessionHas('flash.banner', 'Failed to unfriend the user')
        ->assertSessionHas('flash.bannerStyle', 'danger');
        
    $this->assertDatabaseHas('friends', [
        'requester_id' => $this->requester->id,
        'user_requested_id' => $this->userRequested->id,
        'status' => Friend::PENDING,
    ]);
    

});