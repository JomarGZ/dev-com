<?php

use App\Models\Profile;
use App\Models\User;
use Database\Seeders\WorldSeeder;

test('profile information can be updated', function () {
    $this->seed(WorldSeeder::class);
    $this->actingAs($user = User::factory()->create());

    $response = $this->put('/user/profile-information', [
        'name' => 'Test Name',
        'email' => 'test@example.com',
        'user_id' => $user->id,
        'headline' => 'headlines',
        'about_me' => 'about_me',
        'country_id' => 174,
        'city_id' => 84115,
    ]);
    $user = $user->fresh()->load('profile');
    expect($user)
        ->name->toEqual('Test Name')
        ->email->toEqual('test@example.com')
        ->profile->headline->toEqual('headlines')
        ->profile->about_me->toEqual('about_me')
        ->profile->country_id->toEqual(174)
        ->profile->country->toEqual('Philippines')
        ->profile->city_id->toEqual(84115)
        ->profile->city->toEqual('Lapu-Lapu City');
})->skip();
