<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TopicSeeder::class);

        $topics = Topic::all();

        $users = User::factory(10)
            ->has(Profile::factory())
            ->create();

        $posts = Post::factory(200)
            ->withFixture()
            ->has(Comment::factory(15)->recycle($users))
            ->recycle([$users, $topics])
            ->create();

        User::factory()
            ->has(Post::factory(45)->recycle($topics)->withFixture())
            ->has(Profile::factory())
            ->has(Comment::factory(120))->recycle($posts) 
            ->has(Like::factory()->forEachSequence(
                ...$posts->random(100)->map(fn ($post) => ['likeable_id' => $post]),
            ))
            ->create([
                'name' => 'Jomar Godinez', 
                'email' => 'jomar@example.com',
            ]);
    }
}
