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
            'image' => $this->image,
            'title' => $this->title,
            'description' => $this->description,
            'user' => new ProfileResource($this->user),
            'category' => $this->category_id ? $this->category->name : '',
            'tags' => $this->tags ? $this->tags : null,
            'likes' => $this->likes ? $this->likes : null,
            'comments' => $this->comments ? CommentResource::collection($this->comments) : null
        ];
    }
}
