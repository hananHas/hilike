<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use App\Http\Resources\UserResource;
use App\Models\UserDetail;
use App\Models\Block;
use DB;
use Cache;
class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user_id = Auth::user()->id;
        $user_details = Auth::user()->details;
        $user = $this->first_user == Auth::user()->id ? UserDetail::select(DB::raw('*, ( 6367 * acos( cos( radians('.$user_details->latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$user_details->longitude.') ) + sin( radians('.$user_details->latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
        ->where('user_id',$this->second_user)->first() : UserDetail::select(DB::raw('*, ( 6367 * acos( cos( radians('.$user_details->latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$user_details->longitude.') ) + sin( radians('.$user_details->latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
        ->where('user_id',$this->first_user)->first();

        return [
            'user_id' => $user->user_id,
            'nickname' => $user->nickname,
            'residence_country' => $user->residence_country_name,
            'age' => $user->age,
            'profile_image' => $user->confirmed_image == 1 ? url("images/users/{$user->profile_image}") : null,
            'plan' => $user->plan->name,
            'distance' => isset($user->distance) ?  $user->distance : null,
            'online' => Cache::has('user-is-online-' . $user->user_id) ? 1 : 0,
            'gender' => $user->gender,
            'thread_id' => $this->thread_id,
            'is_blocked' => (Block::where('from_user',$this->first_user)->where('to_user', $this->second_user)->count() + Block::where('from_user',$this->second_user)->where('to_user', $this->first_user)->count()? 1 : 0)
        ];
    }
}
