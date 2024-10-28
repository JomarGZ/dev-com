<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $posts = Post::select('id', 'body', 'user_id', 'created_at', 'updated_at')
            ->with('user:id,name,profile_photo_path,created_at,updated_at')
            ->latest()
            ->latest('id')
            ->paginate(10);
        return inertia('Home', [
            'title' => 'Home',
            'posts' => fn () => PostResource::collection($posts)
        ]);
    }
}
