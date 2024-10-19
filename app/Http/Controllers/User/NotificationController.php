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
       return auth()
        ->user()
        ->unreadNotifications()
        ->findOrFail($id)
        ->markAsRead();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       return auth()
        ->user()
        ->notifications()
        ->find($id)
        ->delete();
    }
}
