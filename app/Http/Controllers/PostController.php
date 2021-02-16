<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\Post as ResourcePost;
use App\Services\PostServices;

class PostController extends Controller
{
    use \App\Http\traits\Handel_Images, \App\Http\traits\Handel_Likes, \App\Http\traits\Handel_comments;

    protected $post;

    protected $only;

    public function __construct()
    {
        $this->authorizeResource('App\Models\Post');
        if (request()->header('x-inertia-partial-data')) {
            $this->only = explode(',', request()->header('x-inertia-partial-data'));
        }
    }

    public function index()
    {
        return inertia('post/index');
    }


    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('post/create', [
            'categories' => function () {
                return Category::all()->map(function ($cat) {
                    return $cat->only('name', 'id');
                });
            },
            'tags' => function () {
                return Tag::all()->map(function ($tag) {
                    return $tag->only('name', 'id');
                });
            },
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, PostServices $services)
    {
        ### create the post
        $this->post = auth()->user()->posts()->create($services->data($request));

        ### add images to the db and storage
        $services->handle_images($this->post);

        ### attach tags and categories
        $services->attach_tags_and_cats();

        return redirect()->route('profile', [auth()->user()->slug])->with("message", 'post created successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return inertia('post/show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->post = Post::query();
        $data = [];

        // if request want categories add the cats relations to the query
        if ($this->only && in_array('categories', $this->only)) {
            $this->post = $this->post->with('categories');
            $data['categories'] = function () {
                $all_cats =  Category::all();
                $all_cats = $all_cats->map(function ($cat) {
                    $cat['checked'] = false;
                    $this->post->categories->each(function ($item) use ($cat) {
                        if ($item->id == $cat->id) {
                            $cat['checked'] = true;
                        }
                    });
                    return $cat->only('name', 'id', 'checked');
                });
                return  $all_cats;
            };
        }

        // if request want tags add the tags relations to the query
        if ($this->only && in_array('tags', $this->only)) {
            $this->post = $this->post->with('tags');
            $data['tags'] = function () {
                $all_tags =  Tag::all();
                $all_tags = $all_tags->map(function ($tag) {
                    $tag['checked'] = false;
                    $this->post->tags->each(function ($item) use ($tag) {
                        if ($item->id == $tag->id) {
                            $tag['checked'] = true;
                        }
                    });
                    return $tag->only('name', 'id', 'checked');
                });
                return $all_tags;
            };
        }

        // if request want images get the user images
        if ($this->only && in_array('images', $this->only)) {
            $this->post = $this->post->with('images');
            $data['images'] = function () {

                return [
                    'post_imgs' => $this->post->images->map(function ($img) {
                        $img = $img->only('id', 'url');
                        $img['url'] = url('storage/' . $img['url']);
                        return $img;
                    }),
                ];
            };
        }

        $post = $this->post->findOrFail($post->id);
        $data['post'] = function () use ($post) {
            return new ResourcePost($post);
        };
        return inertia('post/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostServices $services, PostRequest $request, Post $post)
    {
        ### update the post data 
        $post->update($services->data($request));

        ### add images to the db and storage
        $services->handle_images($post);

        ### attach tags and categories
        $services->attach_tags_and_cats();

        return redirect()->route('profile', [auth()->user()->slug])->with("message", 'Post Updated Successfuly');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->images) {
            $post->images->each(function ($img) use ($post) {
                $this->delete_image($img, $post);
            });
        }
        $post->delete();
        return back(303);
    }
}
