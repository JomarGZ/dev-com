<?php

namespace App\Traits;

use App\Models\Friend;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

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
        try { 
            $friendShip = Friend::create([
                'requester_id' => $this->id,
                'user_requested_id' => $userRequestedId
            ]);
        }catch(QueryException $e){
            throw new Exception('Add friend Error: ' . $e->getMessage(), 500);
        }

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
        try {
            $friendShip = Friend::where('requester_id', $requesterId)
            ->where('user_requested_id', $this->id)
            ->first();
            if ($friendShip) {
                $friendShip->update([
                    'status' => Friend::ACCEPTED
                ]);
                return 1;
            }
        }catch (Exception $e) {
            throw new Exception('Accept friend request ERROR: ' .  $e->getMessage(), 500);
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
        try {
            $friendship = Friend::where('requester_id', $requesterId)
            ->where('user_requested_id', $this->id)
            ->first();
            if ($friendship) {
                $friendship->delete();
                return 1;
            }
        } catch(Exception $e) {
    throw new Exception('Something went wrong while deleting the friend request: ' . $e->getMessage(), 500);
            
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
            if ($this->friendsExisted($friendId)->delete()) {
                return 1;
            }
            return 0;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new Exception('Something went wrong while deleting the friend request: ' . $e->getMessage(), 500);
        }
    }


    public function getFriends(int $status = Friend::ACCEPTED)
    {
        if (!in_array($status, [Friend::PENDING, Friend::ACCEPTED])) {
            throw new InvalidArgumentException("Status must be either " .  Friend::PENDING ." or ". Friend::ACCEPTED);
        }
        return $this->friendsRequested()
            ->wherePivot('status', $status)
            ->get()
            ->merge(
                $this->friendsReceived()
                ->wherePivot('status', $status)
                ->get()
            );
    }

    public function friendsIds()
    {
        return collect($this->getfriends())->pluck('id')->toArray();
    }

    public function isFriendWith(int $id)
    {
        return in_array($id, haystack:$this->friendsIds()) ? 1 : 0;
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
