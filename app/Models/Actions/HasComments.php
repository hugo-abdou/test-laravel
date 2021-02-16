<?php

namespace App\Models\Actions;

use App\Models\Comment;
use App\Models\Post;

trait HasComments
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
