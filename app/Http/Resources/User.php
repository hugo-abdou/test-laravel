<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'slug' => $this->slug,
            'url' => route('profile', $this->slug),
            'email' => $this->email,
            'avatar' => $this->profile_photo_path ? url('storage/' . $this->profile_photo_path) : null,
            'name' => ucwords(strtolower($this->name)),
            'created_at' => Carbon::parse($this->created_at)->format('M d, Y'),
            'country' => $this->country,
            'state' => $this->state,
        ];
    }
}
