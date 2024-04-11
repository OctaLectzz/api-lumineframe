<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
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
            'collection_code' => $this->collection_code,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'user' => new UserResource($this->user),
            'photos' => $this->photos ? PhotoResource::collection($this->photos) : null
        ];
    }
}
