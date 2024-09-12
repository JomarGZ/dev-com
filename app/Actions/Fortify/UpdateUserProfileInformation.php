<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'headline' => ['nullable', 'max:500', 'string'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'about_me' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'integer', 'digits:11']

        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            DB::transaction(function () use ($input, $user) {
                $user->forceFill([
                    'name' => $input['name'],
                    'email' => $input['email'],
                ])->save();
                $user->load('profile');

                $user->profile()->updateOrCreate(
                    ['user_id' => $input['user_id']],
                    [
                        'headline' => $input['headline'],
                        'about_me' => $input['about_me'],
                        'country_id' => $input['country_id'],
                        'city_id' => $input['city_id'],
                    ]);
            });
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        DB::transaction(function () use ($input, $user) {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'email_verified_at' => null,
            ])->save();
            $user->load('profile');

            $user->profile()->updateOrCreate(
                ['user_id' => $input['user_id']],
                [
                    'headline' => $input['headline'],
                    'about_me' => $input['about_me'],
                    'country_id' => $input['country_id'],
                    'city_id' => $input['city_id'],
                ]);
        });
        $user->sendEmailVerificationNotification();
    }
}
