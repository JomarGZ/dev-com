<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index () 
    {
        $profiles = Profile::paginate(10);
        $profiles->load('user');
        return inertia('Profile/Index', [
            'profiles' => ProfileResource::collection($profiles)
        ]);
    }
}
