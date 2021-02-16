<?php

namespace App\Models;

use App\Models\Actions\HasTags;
use App\Models\Actions\HasLikes;
use App\Models\Actions\HasPhotos;
use App\Models\Actions\HasComments;
use App\Models\Actions\HasCategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, HasPhotos, HasComments, HasLikes, HasTags, HasCategories;

    protected $guarded = [];
    protected $casts = [
        'disable_comments' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
