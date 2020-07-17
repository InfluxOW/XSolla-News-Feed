<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'slug', 'created_at', 'category_id'];
    protected $table = 'news';
    protected $with = ['user', 'category'];
    protected $withCount = ['votes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setSlugAttribute($value)
    {
        $slug = slugify("{$value}_" . $this->created_at->format('Y-m-d H:i'));

        $this->attributes['slug'] = $slug;
    }
}
