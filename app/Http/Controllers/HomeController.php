<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Models\Post;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('home/home', [
            'posts' => function () {
                $posts = Post::query();
                $posts->when(request('S'), fn ($query, $s) => $query
                    ->where('title', 'LIKE', '%' . $s . '%')
                    ->orWhere('id', 'LIKE', '%' . $s . '%')
                    ->orWhere('content', 'LIKE', '%' . $s . '%'));
                $posts = $posts->with('images', 'user')->withCount('images');
                $posts = $posts->get();
                return new PostCollection($posts);
            },
        ]);
    }
}
