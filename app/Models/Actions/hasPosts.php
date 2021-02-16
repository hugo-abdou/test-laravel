<?php

namespace App\Models\Actions;

use App\Models\Post;


trait HasPosts
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
