<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $notification = auth()->user()->unreadNotifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $notification = auth()->user()->notifications()->find($id);
       return $notification->delete();
    }
}
