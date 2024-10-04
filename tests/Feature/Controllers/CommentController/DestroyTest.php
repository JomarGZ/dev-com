<?php

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Config;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;

it('require authentication', function() {
    
    delete(route('comments.destroy', Comment::factory()->create()))
        ->assertRedirect(route('login'));
})->skip();
it('can delete a comment', function() {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment));
    
    $this->assertModelMissing($comment);
});

it('can redirect to post show page', function() {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment))
        ->assertRedirect($comment->post->showRoute());
});

it('prevent deleting a comment you didnt create', function() {
    $comment = Comment::factory()->create();

    actingAs(User::factory()->create())
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();
});

it('prevent deleting a comment posted in an hour', function() {
    $this->freezeTime();

    $comment = Comment::factory()->create();

    $this->travel(1)->hour();

    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();
});

it('redirect to the post show page with the page query parameter', function() {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->delete(route('comments.destroy', ['comment' => $comment, 'page' => 2]))
        ->assertRedirect($comment->post->showRoute([ 'page' => 2]));
});
