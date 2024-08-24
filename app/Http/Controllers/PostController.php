<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Scout\Builder as ScoutBuilder;

class PostController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Post::class);
    }
    public function index(Request $request, Topic $topic = null) 
    {
        if ($request->query('query')) {
            $posts = Post::search($request->query('query'))
            ->query(fn (Builder $query) => $query->with(['user', 'topic']))
            ->when($topic, fn (ScoutBuilder $query) => $query->where('topic_id', $topic->id));
     
        } else {
                
            $posts = Post::with(['user', 'topic'])
                ->when($topic, fn (Builder $query) => $query->whereBelongsTo($topic))
                ->latest()
                ->latest('id');
        }

        return inertia('Posts/Index', [
            'posts' => PostResource::collection($posts->paginate()->withQueryString()),
            'topics' => fn () => TopicResource::collection(Topic::all()),
            'selectedTopic' => fn () => $topic ? TopicResource::make($topic) : null,
            'query' => $request->query('query'),
        ]);
    }

   public function create() {
        return inertia('Posts/Create', [
            'topics' => fn() => TopicResource::collection(Topic::all())
        ]);
   }

    public function store(Request $request) {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:10', 'max:120'],
            'topic_id' => ['required', 'exists:topics,id'],
            'body' => ['required', 'string', 'min:100', 'max:10000'],
        ]);

        $post = Post::create([
            ...$data,
            'user_id' => $request->user()->id
        ]);
        $post->save();

        
        return redirect($post->showRoute());
    }
    public function show(Request $request, Post $post) 
    {
        if (! Str::endsWith($post->showRoute(), $request->path())){
            return redirect($post->showRoute($request->query()), status: 301);
        }
        $post->load('user', 'topic');
        return inertia('Posts/Show', [
            'post' => fn () => PostResource::make($post)->withLikePermission(), 
            'comments' => function () use ($post)  {
                $commentResource = CommentResource::collection($post->comments()->with('user')->latest()->latest('id')->paginate(10));
                $commentResource->collection->transform(fn ($resource) => $resource->withLikePermission());

                return $commentResource;
            } 
        ]);
    }
}
