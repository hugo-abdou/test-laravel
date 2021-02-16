<?php

namespace App\Models;

use App\Models\Actions\HasPosts;
use App\Models\Actions\HasPhotos;
use App\Models\Actions\HasFollowers;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPhotos, HasPosts, HasFollowers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'date' => 'datetime',
        'contactOptions' => 'array',
        'gender' => 'array',
        'languages' => 'array',
    ];

    public function like()
    {
        return $this->belongsToMany(Post::class, 'post_like', 'user_id', 'post_id')->withTimestamps();
    }
}
