<?php

namespace App\Http\Resources;

use App\Models\Friend;
use App\Traits\Friendable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private $defaultProfile = [
        'headline' => null,
        'about_me' => null,
        'banner_photo_url' => null,
        'address' => null,
        'phone' => null,
        'user' => null,
    ];
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $loadedProfile = $this->whenLoaded('profile');
        $profile = $loadedProfile ? ProfileResource::make($loadedProfile) : $this->defaultProfile;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->when($this->id === $request->user()?->id, $this->email),
            'profile_photo_path' => $this->profile_photo_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'profile' => $profile,
            'can' => [
                'edit' => $this->id === $request->user()?->id ? true : false
            ],
            'links' => [
                'show' => $this->showRoute()
            ]
        ];
    }
}
