<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use Cache;

class UserResource extends JsonResource
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
            'user_id' => $this->user_id,
            'nickname' => $this->nickname,
            'residence_country' => $this->residence_country_name,
            'age' => $this->age,
            'profile_image' => $this->confirmed_image == 1 ? url("images/users/{$this->profile_image}") : null,
            'plan' => $this->plan->name,
            'distance' => isset($this->distance) ?  $this->distance : null,
            'online' => Cache::has('user-is-online-' . $this->user_id) ? 1 : 0,
            'gender' => $this->gender,
        ];
    }
}
