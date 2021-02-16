<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * toggle attaching tags in the geveen post.
     *
     * @return \Illuminate\Http\Response
     */
    public function toggel_post(Post $post, Request $request)
    {
        if (is_int($request->tag)) {
            $post->tags()->toggle($request->tag);
        }
        return back(303);
    }
}
