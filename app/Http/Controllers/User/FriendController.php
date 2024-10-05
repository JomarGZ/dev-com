<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
     
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
        if (!auth()->user()->addFriend($user->id)) {
            throw new \Exception('Failed to add friend');
        }
        return back()->with('message', 'Friend request sent successfully');       
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user)
    {
        if (!auth()->user()->acceptFriend($user->id)) {
            throw new \Exception('Failed to accept friend request');
        }
        return back()->with('message', 'Friend request accepted successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->deleteFriend($user->id)) {
            throw new \Exception('Failed to unfriend');
        }
        return back()->with('message','Successfully unfriended the user'); 
    }

    public function deny(User $user) 
    {
        if (!auth()->user()->denyFriend($user->id)) {
            throw new \Exception('Failed to deny a friend request');
        }
        return back()->with('message', 'Friend request denied successfully');
    }
}
