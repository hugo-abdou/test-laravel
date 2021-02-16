<?php

namespace App\Models\Actions;

use App\Models\Category;

trait HasCategories
{
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
