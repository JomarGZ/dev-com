<?php

use App\Http\Controllers\PostController;
use App\Http\Resources\PostResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Database\Seeders\WorldSeeder;
use Illuminate\Support\Facades\Config;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

// beforeEach( function () {
//     $this->seed(WorldSeeder::class);
// });

it('requires authentication', function () {
    get(route('home'))
        ->assertRedirect(route('login'));
})->skip();

it('has profile data in the view', function() {

    $user = User::factory()->withProfile()->create();
    $user->load('profile');
    actingAs($user)
        ->get(route('home'))
        ->assertHasResource('user', UserResource::make($user));
})->skip();


it('has paginated posts data in the view', function() {
    $profile = Profile::factory()->create();
    $profile->load('user');
    $posts = Post::factory(3)->create();
    $posts->load(['user', 'topic']);

    actingAs($profile->user)
        ->get(route('home'))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
})->skip();