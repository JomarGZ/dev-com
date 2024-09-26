<?php

namespace App\Traits;

use App\Models\Friend;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;

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
            'requester' => $this->id,
            'user_requested' => $userRequestedId
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
      
        $friendShip = Friend::where('requester', $requesterId)
            ->where('user_requested', $this->id)
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
      
        $friendship = Friend::where('requester', $requesterId)
            ->where('user_requested', $this->id)
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
            $friendship1 = Friend::where('requester', $friendId)
            ->where('user_requested', $this->id)
            ->first();
            
            if ($friendship1) {
                $friendship1->delete();
            }

            $friendship2 = Friend::where('requester', $this->id)
                ->where('user_requested', $friendId)
                ->first();

            if ($friendship2) {
                $friendship2->delete();
            }
            return 1;
        }catch(Exception $e) {
            info('Something went wrong... ERROR info:' . $e->getMessage());
            return 0;
        }
       
    }
    
    public function friends()
    {
        return Friend::select('id', 'requester', 'user_requested', 'status')
            ->where('status', Friend::ACCEPTED)
            ->where(function($query) {
                $query->where('requester', $this->id)
                    ->orWhere('user_requested', $this->id);
            })
            ->get()
            ->map(function($friendship) {
                return $friendship->requester !== $this->id ? $friendship->requester : $friendship->user_requested;
            })
            ->map(function ($friendsId) {
                return User::find($friendsId);
            })
            ->filter();
    }

    public function friendsIds()
    {
        return collect($this->friends())->pluck('id')->toArray();
    }

    public function isFriendWith(int $id)
    {
        return in_array($id, haystack: $this->friendsIds()) ? 1 : 0;
    }

    public function pendingFriendRequests()
    {
        $requesters = Friend::where('status', Friend::PENDING)
            ->where('user_requested', $this->id)
            ->get()
            ->map(function ($friendship){
                return $friendship ? $friendship->requester : null;
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
            ->where('requester', $this->id)
            ->get();
         if ($friendships->isNotEmpty()) {
            foreach($friendships as $friendship):
                array_push($users, User::find($friendship->user_requested));
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

}
