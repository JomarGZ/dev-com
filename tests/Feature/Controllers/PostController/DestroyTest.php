<?php

use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;

it('required authentication', function () {
    $user = User::factory()->create();
    $preparePost = [
        'user_id' => $user->id,
        'body' => 'This is a post'
    ];
    $post = Post::factory()->create($preparePost);
    delete(route('posts.destroy', $post))
        ->assertRedirect(route('login'));
});
it('allow user to delete a post', function () {
    $user = User::factory()->create();
    $preparePost = [
        'user_id' => $user->id,
        'body' => 'This is a post'
    ];
    $post = Post::factory()->create($preparePost);
    actingAs($user)
        ->delete(route('posts.destroy',$post))
        ->assertStatus(302);

    $this->assertDatabaseMissing('posts', $preparePost);
});

it('should not allow user to delete other user post', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $preparePost = [
        'user_id' => $otherUser->id,
        'body' => 'This is a post'
    ];
    $post = Post::factory()->create($preparePost);
   
    actingAs($user)
        ->delete(route('posts.destroy',parameters: $post));

    $this->assertDatabaseHas('posts', [
        ...$preparePost
    ]);
});
