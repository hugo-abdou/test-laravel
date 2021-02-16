<?php

namespace App\Models\Actions;

use App\Models\User;


trait HasLikes
{

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_like', 'post_id', 'user_id');
    }
}
