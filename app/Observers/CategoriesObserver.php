<?php

namespace App\Observers;

use App\Category;

class CategoriesObserver
{
    public function created(Category $category)
    {
        $category->update(['slug' => slugify($category->title)]);
    }
}
