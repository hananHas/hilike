<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','coin_id','price','payment_method','status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class,'coin_id');
    }
}
