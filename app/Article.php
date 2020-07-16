<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'slug'];
    protected $table = 'news';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setSlugAttribute($value)
    {
        $slug = slugify("{$value}_" . now()->format('Y-m-d H:i'));

        $this->attributes['slug'] = $slug;
    }
}
