<?php

use App\Http\Resources\UserResource;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    $user = User::factory()->create();
    get(route('user.show', [$user->id]))
        ->assertRedirect(route('login'));
});

it('should return the correct component', function () {
    $user = User::factory()->create();
    actingAs(User::factory()->create())
        ->get(route('user.show', [$user->id]))
        ->assertComponent('Profile/Show');
});
it('passes profile data to the view', function () {
    $user = User::factory()->create();
    actingAs(User::factory()->create())
        ->get(route('user.show', [$user->id]))
        ->assertHasResource('user', UserResource::make($user));
});
