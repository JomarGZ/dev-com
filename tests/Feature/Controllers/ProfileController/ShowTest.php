<?php

use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\User;

use Database\Seeders\WorldSeeder;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

// beforeAll( function () {
//     $this->seed(WorldSeeder::class);
// });

beforeEach(function () {
    session()->flush();
});
it('requires authentication', function () {
    $user = User::factory()->withProfile()->create();
    $user->load('profile');
    get($user->showRoute())
        ->assertRedirect(route('login'));
})->skip();

it('should return the correct component', function () {
    $user = User::factory()->withProfile()->create();
    $user->load('profile');
    actingAs(User::factory()->create())
        ->get($user->showRoute())
        ->assertComponent('Profile/Show');
})->skip();
it('passes profile data to the view', function () {
    $user = User::factory()->withProfile()->create();
    $user->load('profile');
    actingAs(User::factory()->create())
        ->get($user->showRoute())
        ->assertHasResource('user', UserResource::make($user));
})->skip();
it('only edit profile for the authenticated user', function() {
    $user = User::factory()->withProfile()->create();
   $response = actingAs($user)
                    ->get($user->showRoute());
    $response->assertInertia(fn ($page) => $page
        ->has('user')
        ->where('user.can.edit', true)
    );
})->skip();
