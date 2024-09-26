<?php

use App\Models\Connect;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('profiles.index'))
        ->assertRedirect(route('login'));
});

it('should return the correct component', function () {
    actingAs(User::factory()->create())
        ->get(route('profiles.index'))
        ->assertComponent('Profile/Index');
});
