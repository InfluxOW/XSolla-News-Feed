<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'created_at' => (string) $this->created_at,
            'rating' => $this->votes_count,
            'author' => new UsersResource($this->whenLoaded('user')),
            'category' => new CategoriesResource($this->whenLoaded('category')),
        ];
    }
}
