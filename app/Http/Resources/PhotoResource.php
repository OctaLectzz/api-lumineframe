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
            'photo_number' => $this->photo_number,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id ? $this->category_id : null,
            'image' => $this->image,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category_id ? $this->category->name : '',
            'user' => $this->user ? new UserResource($this->user) : null,
            'tags' => $this->tags ? TagResource::collection($this->tags) : null,
            'likes' => $this->likes,
            // 'collections' => $this->collections ? $this->collections : ''
        ];
    }
}
