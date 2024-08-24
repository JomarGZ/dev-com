<?php

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('require authentication', function () {
    get(route('search.index'))
        ->assertRedirect(route('login'));
});

it('should return the correct component', function() {
    $this->withoutExceptionHandling();
    actingAs(User::factory()->create())
        ->get(route('search.index'))
        ->assertComponent('Profile/Index');

});
it('passes profiles to the view', function () {
    $profiles = Profile::factory(3)->create();
    $profiles->load('user');
    actingAs(User::factory()->create())
       ->get(route('profile.index'))
       ->assertHasPaginatedResource('profiles', ProfileResource::collection($profiles));
});