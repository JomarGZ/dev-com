<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'headline' => $this->headline,
            'about_me' => $this->about_me,
            'banner_photo_url' => $this->banner_photo_url,
            'address' => "{$this->country}, {$this->city}",
            'phone' => $this->phone,
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
