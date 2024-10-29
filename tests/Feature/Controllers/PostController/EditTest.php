<?php

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('required authentication', function(){
    $post = Post::factory()->create();

    $response = $this->get(route('posts.edit', $post));
    $response->assertRedirect(route('login'));
});
it('display correct post data', function(){
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);
    $response = actingAs($user)->get(route('posts.edit',$post));
    $response->assertOk();

    $data = $response->json();
    
    expect($post->user_id)->toBe($user->id);
    expect($data['body'])->toBe($post->body);
});

it('will not allowed the user to edit the post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => User::factory()->create()
    ]);
    $response = actingAs($user)->get(route('posts.edit',$post));
    $response->assertForbidden();
});
