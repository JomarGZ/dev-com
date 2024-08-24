<?php

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;

use function Pest\Laravel\get;

it('can show a post', function() {
    $post = Post::factory()->create();

    get($post->showRoute())
        ->assertComponent('Posts/Show');
        
});

it('passes a post to the view', function () {
    $post = Post::factory()->create();
    $post->load('user', 'topic');
    get($post->showRoute())
        ->assertHasResource('post', PostResource::make($post)->withLikePermission());
});

it('`passes comments to the view`', function () {

    $post = Post::factory()->create();
    $comments = Comment::factory(2)->for($post)->create();
    $comments->load('user');
    $commentResource = CommentResource::collection($comments->reverse());
    $commentResource->collection->transform(fn ($resource) => $resource->withLikePermission());

    get($post->showRoute())
        ->assertHasPaginatedResource('comments', $commentResource);
});

it('will redirect if the slug is incorrect', function (string $incorrectSlug) {
    $post = Post::factory()->create(['title' => 'Hello world']);
    get(route('posts.show', [$post, $incorrectSlug,  'page' => 2]))
        ->assertRedirect($post->showRoute(['page' => 2]));
})->with([
    'hello',
    'foo-bar'
]);