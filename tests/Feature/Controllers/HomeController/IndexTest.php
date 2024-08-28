<?php

use App\Http\Controllers\PostController;
use App\Http\Resources\PostResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('home.index'))
        ->assertRedirect(route('login'));
});

it('has profile data in the view', function() {
    $user = User::factory()->withProfile()->create();
    $user->load('profile');
    actingAs($user)
        ->get(route('home.index'))
        ->assertHasResource('user', UserResource::make($user));
});


it('has paginated posts data in the view', function() {
    $profile = Profile::factory()->create();
    $profile->load('user');
    $posts = Post::factory(3)->create();
    $posts->load(['user', 'topic']);

    actingAs($profile->user)
        ->get(route('home.index'))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
});