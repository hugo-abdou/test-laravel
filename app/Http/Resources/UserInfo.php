<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'auth_follow_user' => $this->followers->where('id', auth()->id())->first(),
            'slug' => $this->slug,
            'url' => route('profile', $this->slug),
            'avatar' => $this->profile_photo_path ? url('storage/' . $this->profile_photo_path) : null,
            'name' => ucwords(strtolower($this->name)),
        ];
    }
}
