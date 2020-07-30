<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store', 'update', 'destroy');
    }

    public function index(Request $request)
    {
        $orderBy = $request->sortByRating == true ? 'votes_count' : 'created_at';
        $news = Article::orderBy($orderBy, 'desc')->without('category')->get();

        return NewsResource::collection($news);
    }

    public function store(NewsRequest $request)
    {
        $article = $request->user()->createArticle($request->validated());

        return new NewsResource($article);
    }

    public function show(Article $article)
    {
        return new NewsResource($article);
    }

    public function update(NewsRequest $request, Article $article)
    {
        $this->authorize($article);

        $article->update($request->validated());

        return new NewsResource($article);
    }

    public function destroy(Article $article)
    {
        $this->authorize($article);

        $article->delete();

        return response()->noContent();
    }
}
