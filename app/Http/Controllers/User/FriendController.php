<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Meilisearch\Client;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $meiliSearchClient = new Client('http://localhost:7700', 'test');
        // $meiliSearchClient->index('users')->deleteAllDocuments();
        $query = $request->query('userQuery');
        if ($query) {
            $users = User::search($query)
                        ->paginate(20)->withQueryString(); // Perform search with Scout
        }
        return inertia('Network/Index',[
            'users' => fn () => (isset($users) && !empty($users)) 
                ? UserResource::collection($users) 
                : null,
            'title' => 'Networks',
            'userQuery' => $query
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user)
    {
        return auth()->user()->addFriend($user->id) 
            ? back()->banner('Friend request sent successfully')    
            : back()->dangerBanner('Failed to sent friend request');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user)
    {
        return auth()->user()->acceptFriend($user->id) 
            ? back()->banner('Friend request accepted successfully') 
            : back()->dangerBanner('Failed to accept the friend request'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return auth()->user()->deleteFriend($user->id) 
            ? back()->banner('Successfully unfriended the user') 
            : back()->dangerBanner('Failed to unfriend the user'); 
    }

    public function deny(User $user) 
    {
        return auth()->user()->denyFriend($user->id)
            ? back()->banner('Friend request denied successfully')
            : back()->dangerBanner('Friend request deny failed');
    }
}
