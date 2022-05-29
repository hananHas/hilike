<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use Auth;
use App\Models\Countries;
class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang = Auth::user()->details->language;
        if($lang == 'en'){
            return [
                'about' => $this->about,
                'looking_for' => $this->looking_for,
                'dob' => (string) $this->age,
                'origin_country' => $this->origin_country_name,
                'residence_country' => $this->residence_country_name,
                'religion' => isset($this->religion) ? $this->religion->name : null,
                'social_type' => isset($this->social_type) ? $this->social_type->name : null, 
                'marriage_type' => isset($this->marriage_type) ? $this->marriage_type->name : null,
                'education' => isset($this->education) ? $this->education->name : null,
                'job' => isset($this->job) ? $this->job->name : null,
                'children' => $this->children,
                'smoking' => $this->smoking,
                'language' => $this->language,
                'native_language' => $this->native_language,
                'height' => $this->height,
                'skin_color' => isset($this->skin_color) ? $this->skin_color->name : null,
                'body' => isset($this->body) ? $this->body->name : null,
            ];
        }else{
            return [
                'about' => $this->about,
                'looking_for' => $this->looking_for,
                'dob' => $this->age,
                'origin_country' => $this->origin_country_name,
                'residence_country' => $this->residence_country_name,
                'religion' => isset($this->religion->translate) ? $this->religion->translate->name : null,
                'social_type' => isset($this->social_type->translate) ? $this->social_type->translate->name : null,
                'marriage_type' => isset($this->marriage_type->translate) ? $this->marriage_type->translate->name : null,
                'education' => isset($this->education->translate) ? $this->education->translate->name : null,
                'job' => isset($this->job->translate) ? $this->job->translate->name : null,
                'children' => $this->children,
                'smoking' => $this->smoking,
                'language' => $this->language,
                'native_language' => $this->native_language,
                'height' => $this->height,
                'skin_color' => isset($this->skin_color->translate) ? $this->skin_color->translate->name : null,
                'body' => isset($this->body->translate) ? $this->body->translate->name : null,
            ];
        }
        
    }
}
