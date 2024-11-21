<?php

use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('required authentication', function () {
    $post = Post::factory()->create();

    $response = $this->put(route('posts.update', $post));
    $response->assertRedirect(route('login'));
});
it('allow the user to update his/her post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'body' => 'Old body'
    ]);
    $response = actingAs($user)->put(route('posts.update', $post), [
        'body' => 'The body has changed'
    ]);
    $response->assertStatus(302);
    $response->assertRedirect(route('home'));
    $post->refresh();
    expect($post->user_id)->toBe($user->id);
    expect($post->body)->toBe('The body has changed');
    
});
it('will not allow the user to update other user post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => User::factory()->create()
    ]);
    $response = actingAs($user)->put(route('posts.update', $post), [
        'body' => 'The body has changed'
    ]);
    $response->assertForbidden();
});