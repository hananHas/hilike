<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportChatResource extends JsonResource
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
            'id' => $this->thread_id,
            'user_id' => $this->s_user->id,
            'nickname' => $this->s_user->details->nickname,
            'gender' => $this->s_user->details->gender,
            'profile_image' => $this->s_user->details->confirmed_image == 1 ? url("images/users/{$this->s_user->details->profile_image}") : null,
            'thread_id' => $this->thread_id,
            'count' => 0,
            'last_message' => $this->created_at,
            'category_name' => $this->category->name,
        ];
    }
}
