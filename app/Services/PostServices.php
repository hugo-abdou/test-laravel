<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\traits\Handel_Images;

class PostServices
{
    use Handel_Images;

    protected $post;

    protected $hasImages = [];

    public function __construct()
    {
    }

    /**
     * filter the gevin validated data
     * @return Array
     */
    public function data($request)
    {
        $this->handle_blocks($request);
        return $this->post;
    }

    public function handle_blocks(Request $request)
    {
        $data = $request->validated();
        $this->post = $data;

        ### extract images from the content and replace it with url
        $data['content']['blocks'] = collect($data['content']['blocks'])->map(function ($block) {
            if ($block['type'] == 'image') {
                $dataUrl = $block['data']['url'];
                if (str_contains($dataUrl, 'data:image')) {
                    $name = $this->make_image_name($dataUrl);
                    $img_url = config('filesystems.uploads.media.get') . $name;
                    $this->hasImages[] = [
                        'url' =>  $img_url,
                        'dataUrl' =>  $dataUrl
                    ];
                    $block['data']['url'] = $img_url;
                } else {
                    $this->hasImages[] = [
                        'url' =>   $dataUrl,
                        'dataUrl' =>  null
                    ];
                }
            }
            return $block;
        })->toArray();
        $this->post['content'] = \json_encode($data['content']);
    }
    public function  handle_images(Post $post)
    {
        $this->post = $post;

        collect($this->hasImages)->map(function ($img) use ($post) {
            if (!$this->post->images->where('url', $img['url'])->first())
                $this->add_image($img);
        });

        if ($this->post->images) {
            $this->post->images->map(function ($img) {
                if (!collect($this->hasImages)->where('url', $img->url)->first())
                    $this->delete_image($img, $this->post);
            });
        }
    }
    public function attach_tags_and_cats()
    {
        $this->attach_categories(request());
        $this->attach_tags(request());
    }
    protected function attach_categories(Request $request)
    {
        if (is_array($request->categories) && boolval($request->categories)) {
            collect($request->categories)->each(function ($cat) {
                if (key_exists('checked', $cat))
                    if ($cat['checked'])
                        $this->post->categories()->attach($cat['id']);
            });
        }
    }
    protected function attach_tags(Request $request)
    {
        if (is_array($request->tags) && boolval($request->tags)) {
            collect($request->tags)->each(function ($tag) {
                if (key_exists('checked', $tag))
                    if ($tag['checked'])
                        $this->post->tags()->attach($tag['id']);
            });
        }
    }
}
