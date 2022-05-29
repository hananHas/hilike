<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public function translate()
    {
        return $this->morphOne(Translate::class, 'translatable');
    }

    public function packages()
    {
        return $this->hasMany(PlanPackage::class, 'plan_id');
    }

    public function subscribe()
    {
        return $this->morphMany(Subscription::class, 'subscriptable');
    }
}
