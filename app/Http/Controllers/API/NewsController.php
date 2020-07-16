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

    public function index()
    {
        $news = Article::all();

        return NewsResource::collection($news);
    }

    public function store(NewsRequest $request)
    {
        $user = $request->user();
        $article = $user->news()->create($request->validated());

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
