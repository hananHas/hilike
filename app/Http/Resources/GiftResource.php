<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GiftResource extends JsonResource
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
            'id' => $this->id,
            'image' => url("images/gifts/{$this->gift->image}"),
            'price' => $this->gift->price,
            'profile_image' => $this->user->details->profile_image?url("images/users/{$this->user->details->profile_image}"):null,
            'user_id' => $this->from_user,
        ];
    }
}
