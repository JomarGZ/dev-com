<?php

namespace Database\Seeders;

use App\Models\Friend;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class FriendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Friend::factory(20)->create();
        Cache::forget('10_users_data');
    }
}
