<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPackage extends Model
{

    protected $fillable = [
        'price','months','plan_id'
    ];

    use HasFactory;

    public function subscribe()
    {
        return $this->morphMany(Subscription::class, 'subscriptable');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class,'plan_id');
    }
}
