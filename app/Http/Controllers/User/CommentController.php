<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Comment::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        Comment::make([
            ...$request->validate(['body' => ['required','string', 'max:2500']]),
            'user_id' => $request->user()->id,
            'post_id' => $post->id
        ])->save();

        return redirect($post->showRoute())->banner('Comment added');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:2500']]);

        $comment->update($data);

        return redirect($comment->post->showRoute(['page' => $request->query('page')]))->banner('Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        
        $comment->delete();

        return redirect($comment->post->showRoute(['page' => $request->query('page')]))->banner('Comment Successfully deleted!');
    }
}
