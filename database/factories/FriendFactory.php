<?php

namespace Database\Factories;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $users = User::take(10)->get();    

        $requester = $users->random(1)->first();
        $userRequested = $users->filter(function($user) use ($requester) {
            return $user->id != $requester->id;
        })->take(1)->first();

        return [
            'requester' => $requester->id,
            'user_requested' => $userRequested->id,
            'status' => array_rand([Friend::PENDING, Friend::ACCEPTED], 1)
        ];
    }
}
