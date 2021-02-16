<?php

namespace App\Models\Actions;

use App\Models\User;
use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasPhotos
{

    public function images()
    {
        // return many images
        return $this->morphMany(Image::class, 'imageable');
    }
    public function image()
    {
        // return one image
        return $this->morphOne(Image::class, 'imageable');
    }
    /**
     * Update the user images.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updateMedia(UploadedFile $photo, $role)
    {
        tap(
            auth()->user()->images->firstWhere('role', $role),
            function ($prev) use ($photo, $role) {
                !$prev
                    ?: $prev->update([
                        'role' => ''
                    ]);
                // get the photo path
                $photoUrl = $photo->store(
                    'uploads',
                    $this->mediaDisk()
                );
                // update the user avatar url
                if ($role == 'avatar') {
                    auth()->user()->update([
                        'profile_photo_path' => $photoUrl
                    ]);
                }
                // add the image to the images collection 
                auth()->user()->images()->create([
                    'url' => $photoUrl,
                    'role' => $role,
                    'user_id' => auth()->user()->id
                ]);
            }
        );
    }

    /**
     * delete the user's photo.
     *
     * @param  \App\Image  $photo
     * @return void
     */
    public function destroyMedia(Image $photo)
    {
        if ($photo->user_id === auth()->user()->id) {

            if ($photo->role == 'avatar') {
                auth()->user()->update([
                    'profile_photo_path' => ''
                ]);
            }

            if ($photo->delete() && Storage::disk($this->mediaDisk())->delete($photo->url)) {
                return back(303)->with('status', 'photo deleted succefly');
            }
            return back(303)->with('status', 'someting rong try agan');
        }
        return back(303)->with(['mesage' => 'you ar not alaod', 'status' => 'notOk']);
    }
    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function mediaDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }
}
