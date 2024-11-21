<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Friend;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)
            ->has(Profile::factory())
            ->create();

      
        User::factory()
            ->has(Profile::factory())
            ->create([
                'name' => 'Jomar Godinez', 
                'email' => 'jomar@example.com',
            ]);
        
    }
}
