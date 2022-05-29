<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subscriptable_type','subscriptable_id','price','is_trial','ends_at',
        'status','sent_message','payment_method'
    ];

    public function subscriptable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
