<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGift extends Model
{
    use HasFactory;

    public function gift()
    {
        return $this->belongsTo(Gift::class,'gift_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'from_user');
    }

    public function user_to()
    {
        return $this->belongsTo(User::class,'to_user');
    }
}
