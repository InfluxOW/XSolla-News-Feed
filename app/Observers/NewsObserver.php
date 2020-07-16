<?php

namespace App\Observers;

use App\Article;

class NewsObserver
{
    public function created(Article $article)
    {
        $article->update(['slug' => $article->title]);
    }

    public function updated(Article $article)
    {
        $slug = slugify("{$article->title}_" . $article->updated_at->format('Y-m-d H:i'));

        if ($article->slug !== $slug) {
            $article->update(['slug' => $article->title]);
        }
    }
}
