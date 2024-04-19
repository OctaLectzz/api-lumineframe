<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'avatar' => $this->avatar,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'role' => $this->role,
            'about' => $this->about,
            'pronouns' => $this->pronouns,
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'url' => $this->url,
            'address' => $this->address,
            'photos' => $this->photos ? PhotoResource::collection($this->photos) : null,
            'likes' => $this->likes ? LikeResource::collection($this->likes) : null,
            'collections' => $this->collections ? CollectionResource::collection($this->collections) : null,
            'collectionphoto' => $this->collectionphoto ? CollectionPhotoResource::collection($this->collectionphoto) : null,
            'status' => $this->status == 1 ? true : false
        ];
    }
}
