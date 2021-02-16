<?php

namespace App\Models\Actions;

use App\Models\Tag;

trait HasTags
{
   public function tags()
   {
      return $this->belongsToMany(Tag::class);
   }
}
