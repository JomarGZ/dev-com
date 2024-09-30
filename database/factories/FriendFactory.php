<?php

namespace Database\Factories;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cache;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Friend>
 */
class FriendFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $users = Cache::rememberForever('10_users_data', function () {
            return User::take(10)->get();    
        });

        $requester = $users->random();
        $userRequested = $users->shuffle()->filter(function($user) use ($requester) {
            return !$user->friendsExisted($requester->id) && $user->id !== $requester->id;
        })->first();
        
        return [
            'requester_id' => $requester->id,
            'user_requested_id' => $userRequested->id,
            'status' => array_rand([Friend::PENDING, Friend::ACCEPTED], 1)
        ];
    }
}
