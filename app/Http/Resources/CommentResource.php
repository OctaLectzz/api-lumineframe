<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CommentResource extends JsonResource
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
            'photo_id' => $this->photo_id,
            'avatar' => $this->user->avatar,
            'name' => $this->user->first_name . ' ' . $this->user->last_name,
            'content' => $this->content,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
