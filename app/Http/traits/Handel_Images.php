<?php

namespace App\Http\traits;


use App\Models\Post;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait Handel_Images
{
    /**
     * return image name.jpg
     * @param  string the image dataUrl
     * @return string $name
     */
    public function make_image_name($url)
    {
        # extand the image type from the dataUrl  [png jpg gif ext....]
        $type = explode('/', explode(':', substr($url, 0, strpos($url, ';')))[1])[1];
        #genarate name for the image
        $name = random_int(1000, 9000) . time() . '.' . $type;
        return $name;
    }
    /**
     * add images to the db and storage
     * @param  string the image file
     * @return void
     */
    public function add_image($img)
    {
        $this->post->images()->create([
            'url' => $img['url'],
            'user_id' => auth()->id()
        ]);
        if ($img['dataUrl']) {
            $name = str_replace(env('APP_URL') . '/storage/uploads/', '', $img['url']);
            Image::make($img['dataUrl'])->save(config('filesystems.uploads.media.set') . $name);
        }
    }
    /**
     * add images to the db and storage
     * @param  string the image file
     * @return void
     */
    public function delete_image($img, Post $post)
    {
        $image = $post->images()->where('url', $img->url)->first();
        if ($image) {
            $image_path = str_replace(env('APP_URL') . '/storage/', 'public/', $image->url);
            if (Storage::exists($image_path)) {
                Storage::delete($image_path);
            }
            $image->delete();
        }
    }
}
