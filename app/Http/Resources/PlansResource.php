<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlansResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'description' => explode(",",$this->description) ,
            'ar_description' => explode(",",$this->ar_description) ,
            'packages' => PackagesResource::collection($this->packages)->sortBy('months')->toArray()
        ];
    }
}
