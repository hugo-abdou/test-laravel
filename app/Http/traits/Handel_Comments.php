<?php

namespace App\Http\traits;


use App\Models\Post;
use Illuminate\Http\Request;

trait Handel_Comments
{

    /**
     * comment in the geveen post.
     *
     * @return \Illuminate\Http\Response
     */
    public function comment(Post $post, Request $request)
    {
        if ($request->content == '') {
            return back(303);
        }
        $data = $request->validate(['content' => 'required|string']);
        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'content' => $data['content']
        ]);
        return back(303);
    }
}
