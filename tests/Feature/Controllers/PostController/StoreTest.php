<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('required authentication', function () {
    post(route('posts.store'))
        ->assertRedirect(route('login'));
});
it('allow to create a post', function () {
    $user = User::factory()->create();
    $postData = [
        'body' => str_repeat('a', 200)
    ];
    actingAs($user)
        ->post(route('posts.store'), $postData)
        ->assertStatus(302);

    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
        ...$postData
    ]);
});
