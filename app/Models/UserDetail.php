<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nickname',
        'about',
        'age',
        'looking_for',
        'origin_country_name',
        'origin_latitude',
        'origin_longitude',
        'residence_country_name',
        'residence_latitude',
        'residence_longitude',
        'gender',
        'state',
        'religion_id',
        'social_type_id',
        'marriage_type_id',
        'education_id',
        'job_id',
        'children',
        'smoking',
        'language',
        'native_language',
        'height',
        'skin_color_id',
        'body_id',
        'plan_id',
        'latitude',
        'longitude',
        'online',
        'profile_progress',
        'last_visit',
        'profile_image',
        'confirmed_image',
        'balance',
        'location',
        'visible',
        'confirmed_nickname',
        'confirmed_looking_for',
        'confirmed_about',
        'notification_messages',
        'notification_likes',
        'notification_nearby',

    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function origin_country()
    {
        return $this->belongsTo(Country::class,'origin_country_id');
    }

    
    public function residence_country()
    {
        return $this->belongsTo(Country::class,'residence_country_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class,'plan_id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class,'religion_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function social_type()
    {
        return $this->belongsTo(SocialType::class,'social_type_id');
    }

    public function marriage_type()
    {
        return $this->belongsTo(MarriageType::class,'marriage_type_id');
    }

    public function education()
    {
        return $this->belongsTo(Education::class,'education_id');
    }

    public function skin_color()
    {
        return $this->belongsTo(SkinColor::class,'skin_color_id');
    }

    public function body()
    {
        return $this->belongsTo(Body::class,'body_id');
    }

    public function getWantedGenderAttribute()
    {
        if($this->gender == 'male')
        return 'female';
        else
        return 'male';
    }

    // public function getAgeAttribute()
    // {
    //     return Carbon::parse($this->dob)->age;
    // }

   
}
