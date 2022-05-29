<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminChatResource extends JsonResource
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
            'user_id' => 0,
            'nickname' => 'Hilike',
            'residence_country' => '',
            'age' => 0,
            'profile_image' => url('logo.png'),
            'plan' => 'admin',
            'distance' => 0,
            'online' => 0,
            'gender' => '',
            'thread_id' => $this->thread_id,
            'is_blocked' => 0
        ];
    }
}
