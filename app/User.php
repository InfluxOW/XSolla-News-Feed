<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function news()
    {
        return $this->hasMany(Article::class);
    }

    public function createArticle($data)
    {
        return $this->news()->create($data);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function hasVotedFor(Article $article)
    {
        return $article->votes()->where('user_id', $this->id)->exists();
    }

    public function upvote(Article $article)
    {
        if (! $this->hasVotedFor($article)) {
            $vote = $this->votes()->make();
            $article->votes()->save($vote);
        }
    }

    public function downvote(Article $article)
    {
        if ($this->hasVotedFor($article)) {
            $vote = $article->votes()->where('user_id', $this->id)->first();
            $vote->delete();
        }
    }
}
