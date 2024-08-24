<?php

use App\Models\Post;
use Illuminate\Support\Str; 
it('uses title case for titles', function() {
    $post = Post::factory()->create(['title' => 'Hello, how are you?']);

    expect($post->title)->toBe('Hello, How Are You?');
});

it('can generate a route to the show page', function () {
    $post = Post::factory()->create();

    expect($post->showRoute())->toBe(route('posts.show', [$post, Str::slug($post->title)]));
});


it('can generate addition query parameters on show route', function () {
    $post = Post::factory()->create();
    $page = ['page' => 2];
    expect($post->showRoute($page))->toBe(route('posts.show', [$post, Str::slug($post->title), ...$page]));
});

it('generates the html', function () {
    $post = Post::factory()->make(['body' => '## Hello world']);
    
    $post->save();

    expect($post->html)->toEqual(str($post->body)->markdown());
});