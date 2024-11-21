<?php

namespace App\Http\Resources;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class PostResource extends JsonResource
{

 
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'user'         => UserResource::make($this->whenLoaded('user')),
            'body'         => $this->body,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
            'can'          => [
                'delete'    => $request->user()?->can('delete', $this->resource),
                'edit'      => $request->user()?->can('update', $this->resource)
            ]
        ];
    }
}
