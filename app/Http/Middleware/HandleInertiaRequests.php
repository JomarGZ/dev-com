<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        if ($user) {
            $user->load('profile');
        }
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user ? array_merge($user->toArray(), [
                    'profile' => [
                        'headline' => $user->profile->headline ?? null,
                        'country_id' => $user->profile->country_id ?? null,
                        'city_id' => $user->profile->city_id ?? null,
                        'about_me' => $user->profile->about_me ?? null,
                        'phone' => $user->profile->phone ?? null,
                    ]
                ]) : null
            ],
            'permissions' => [
                'create_posts' => $request->user()?->can('create', Post::class)
            ]
        ]);
    }
}
