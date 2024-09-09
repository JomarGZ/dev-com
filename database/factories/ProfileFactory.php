<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $headlines = [
            'Web Developer | HTML | CSS | jQuery | JavaScript | PHP Laravel',
            'Research Analyst / Data Entry Analyst',
            'Co-Founder at Passafund | We make financial services accessible',
            'Recruitment Specialist',
        ];

        return [
            'user_id' => User::factory(),
            'headline' => fake()->randomElement($headlines),
            'about_me' => Collection::times(3, fn () => fake()->realText(200))->join(PHP_EOL.PHP_EOL),
            'banner_photo_url' => null,
            'country' => 'Philippines',
            'city' => 'Lapu-Lapu City',
            'phone' => fake()->phoneNumber(),
            'country_id' => 174,
            'city_id' => 84115
        ];
    }
}
