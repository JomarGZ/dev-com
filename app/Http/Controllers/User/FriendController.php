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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user)
    {
        return auth()->user()->addFriend($user->id) 
            ? back()->banner('Friend request sent successfully')    
            : back()->banner('Already sent a friend request');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user)
    {
        return auth()->user()->acceptFriend($user->id) 
            ? back()->banner('Friend request accepted successfully') 
            : back()->banner('Friend request accepted failed'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return auth()->user()->deleteFriend($user->id) 
            ? back()->banner('Successfully unfriended the user') 
            : back()->banner('Failed to unfriended the user'); 
    }
}
