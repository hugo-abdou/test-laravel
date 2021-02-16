<?php

namespace App\Http\traits;

use App\Models\Post;


trait Handel_Likes
{

    /**
     * like the geveen post.
     *
     * @return \Illuminate\Http\Response
     */
    public function like(Post $post)
    {
        $post = auth()->user()->like()->toggle($post);
        return back(303);
    }
}
