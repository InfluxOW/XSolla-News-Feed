<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'slug', 'description'];
    protected $withCount = ['news'];

    public function news()
    {
        return $this->hasMany(Article::class);
    }
}
