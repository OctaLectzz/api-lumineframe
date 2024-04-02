<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'user' => $this->user->name,
            'image' => $this->image,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category->name,
            'tags' => $this->tags,
            'likes' => $this->likes,
            'collections' => $this->collections
        ];
    }
}
