<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\User;
use App\Services\LocationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Agent;
use Laravel\Jetstream\Http\Controllers\Inertia\Concerns\ConfirmsTwoFactorAuthentication;
use Laravel\Jetstream\Jetstream;
use Nnjeim\World\World;
use Illuminate\Support\Str;
class ProfileController extends Controller
{
    use ConfirmsTwoFactorAuthentication;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        if (! Str::endsWith($user->showRoute(), $request->path())) {
                return redirect($user->showRoute($request->query()), 301);
        }
        $user->load(['profile:country,city,headline']);
        $authUser = auth()->user();
        return inertia('Profile/Show', [
            'user' => UserResource::make($user),
            'status' => [
                'isFriendWith' => $authUser->isFriendWith($user->id),
                'friendRequestSentTo' => $authUser->hasPendingFriendRequestTo($user->id),
                'friendRequestReceivedFrom' => $authUser->hasPendingFriendRequestFrom($user->id),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $this->validateTwoFactorAuthenticationState($request);
        $locationService = new LocationService;

        $countries = $locationService->countries();

        $countryId = isset($request->user()->profile->country_id) ? $request->user()->profile->country_id : null;
       
        $cities = $locationService->citiesByCountryId($countryId);
        return Jetstream::inertia()->render($request, 'Profile/Edit', [
            'confirmsTwoFactorAuthentication' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
            'sessions' => $this->sessions($request)->all(),
            'countries' => $countries,
            'cities' => isset($cities) ? $cities : null
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $request->user()->getAuthIdentifier())
                    ->orderBy('last_activity', 'desc')
                    ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Laravel\Jetstream\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent(), fn ($agent) => $agent->setUserAgent($session->user_agent));
    }

  
}
