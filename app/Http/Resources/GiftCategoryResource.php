<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AllGiftsResource;
use Auth;

class GiftCategoryResource extends JsonResource
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
            'name' => Auth::user()->details->language=='en' ? $this->name : $this->translate->name,
            'gifts' => AllGiftsResource::collection($this->gifts)
            
        ];
    }
}
