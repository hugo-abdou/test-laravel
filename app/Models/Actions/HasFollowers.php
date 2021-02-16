<?php

namespace App\Models\Actions;

use App\Models\User;


trait HasFollowers
{
    public function follow()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follow_id')->withTimestamps();
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follow_id', 'user_id')->withTimestamps();
    }
}
