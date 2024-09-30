<?php

namespace App\Traits;

use App\Models\Friend;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

trait Friendable
{
    public function addFriend(int $userRequestedId)
    {
        if ($this->id === $userRequestedId || $userRequestedId <= 0) {
            return 0;
        }

        if ($this->isFriendWith($userRequestedId)) {
            return 0;
        }
        if ($this->hasPendingFriendRequestFrom($userRequestedId)) {
            return 0;
        }
        if ($this->hasPendingFriendRequestTo($userRequestedId)) {
            return 0;
        }

        $friendShip = Friend::create([
            'requester_id' => $this->id,
            'user_requested_id' => $userRequestedId
        ]);

        return $friendShip ? 1 : 0;
    }

    public function acceptFriend(int $requesterId)
    {
        
        if (empty($requesterId) || $requesterId <= 0) {
            return 0;
        }
        if (!$this->hasPendingFriendRequestFrom($requesterId)) {
            return 0;
        }
        $friendShip = Friend::where('requester_id', $requesterId)
            ->where('user_requested_id', $this->id)
            ->first();
        if ($friendShip) {
            $friendShip->update([
                'status' => Friend::ACCEPTED
            ]);
            return 1;
        }

        return 0;
    }

    public function denyFriend(int $requesterId)
    {
        if (empty($requesterId) || $requesterId <= 0) {
            return 0;
        }
        if (!$this->hasPendingFriendRequestFrom($requesterId)) {
            return 0;
        }
      
        $friendship = Friend::where('requester_id', $requesterId)
            ->where('user_requested_id', $this->id)
            ->first();
        if ($friendship) {
            $friendship->delete();
            return 1;
        }

        return 0;
    }

    public function deleteFriend(int $friendId)
    {
        if (empty($friendId) || $friendId <= 0 || $this->id === $friendId) {
            return 0;
        }
        if (!$this->isFriendWith($friendId)) {
            return 0;
        }

        try {
            $friendship1 = Friend::where('requester_id', $friendId)
            ->where('user_requested_id', $this->id)
            ->first();
            
            if ($friendship1) {
                $friendship1->delete();
            }

            $friendship2 = Friend::where('requester_id', $this->id)
                ->where('user_requested_id', $friendId)
                ->first();

            if ($friendship2) {
                $friendship2->delete();
            }
            return 1;
        }catch(\Illuminate\Database\QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());
            throw new Exception('Something went wrong while deleting the friend request.');
        }
       
    }
    
    public function getFriends()
    {
        return $this->friends->filter(function ($friend) {
            return $friend->id !== $this->id && $friend->pivot->status === Friend::ACCEPTED;
        }); 
    }

    public function friendsIds()
    {
        return collect($this->getfriends())->pluck('id')->toArray();
    }

    public function isFriendWith(int $id)
    {
        return in_array($id, haystack: $this->friendsIds()) ? 1 : 0;
    }

    public function pendingFriendRequests()
    {
        $requesters = Friend::where('status', Friend::PENDING)
            ->where('user_requested_id', $this->id)
            ->get()
            ->map(function ($friendship){
                return $friendship ? $friendship->requester_id : null;
            })
            ->map(function ($requesterId) {
                    return User::find($requesterId);
            })
            ->filter();
       
        return $requesters;
    }

    public function pendingFriendRequestSent()
    {
        $users = array();

        $friendships = Friend::where('status', Friend::PENDING)
            ->where('requester_id', $this->id)
            ->get();
         if ($friendships->isNotEmpty()) {
            foreach($friendships as $friendship):
                array_push($users, User::find($friendship->user_requested_id));
            endforeach;
         }

         return $users;
    }

    public function pendingFriendRequestIds()
    {
        return collect($this->pendingFriendRequests())->pluck('id')->toArray();
    }

    public function pendingFriendRequestSentIds()
    {
        return collect($this->pendingFriendRequestSent())->pluck('id')->toArray();
    }

    public function hasPendingFriendRequestFrom(int $id)
    {
        return in_array($id, $this->pendingFriendRequestIds()) ? 1 : 0;
    }

    public function hasPendingFriendRequestTo(int $id)
    {
        return in_array($id, $this->pendingFriendRequestSentIds()) ? 1 : 0;
    }

    public function friendsExisted(int $id) 
    {
        if (!$id || $id <= 0) {
            return collect([]);
        }
        return Friend::select('id', 'requester_id', 'user_requested_id', 'status')
            ->where(function($query) use ($id)  {
                $query->where(function($query) use ($id)  {
                    $query->where('requester_id', $this->id)
                        ->where('user_requested_id',$id);
                })
                ->orWhere(function($query) use ($id)  {
                    $query->where('requester_id', $id)
                        ->where('user_requested_id',$this->id);
                });
            })
            ->first();
      
    }

}
