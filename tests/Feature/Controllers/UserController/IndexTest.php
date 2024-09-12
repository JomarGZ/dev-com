<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('user.index'))
        ->assertRedirect(route('login'));
});

it('should return the correct component', function () {
    actingAs(User::factory()->create())
        ->get(route('user.index'))
        ->assertComponent('Profile/Index');
});
