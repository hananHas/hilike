<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $old_price = $this->plan->price * $this->months;
        $percantage = round(($this->price / $old_price) * 100);
        return [
            'id' => $this->id,
            'months' => $this->months,
            'price' => $this->price,
            'old_price' => $old_price,
            'percantage' => $percantage
        ];
    }
}
