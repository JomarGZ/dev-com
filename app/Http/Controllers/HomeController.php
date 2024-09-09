<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $user = User::findOrFail(request()->user()->id);
        $user->load('profile');

        $posts = Post::latest()->latest('id')->paginate();
        $posts->load(['user', 'topic']);
        
        return inertia('Home', [
            'user' => UserResource::make($user),
            'posts' => fn () => $posts ? PostResource::collection($posts) : null,
            'title' => 'Home'
        ]);
    }
}
