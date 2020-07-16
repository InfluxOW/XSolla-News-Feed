<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request, Article $article)
    {
        $user = $request->user();

        if ($user->hasVotedFor($article)) {
            return ['message' => "You can't upvote the same article twice."];
        }

        $user->upvote($article);

        return ['article' => new NewsResource($article->fresh())];
    }

    public function destroy(Request $request, Article $article)
    {
        $user = $request->user();

        if (! $user->hasVotedFor($article)) {
            return ['message' => "You can't downvote having no upvote."];
        }

        $user->downvote($article);

        return ['article' => new NewsResource($article->fresh())];
    }
}
