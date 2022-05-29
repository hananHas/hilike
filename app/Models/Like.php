<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user',
        'to_user',
    ];

    public function user_from()
    {
        return $this->belongsTo(User::class,'from_user');
    }

    public function user_to()
    {
        return $this->belongsTo(User::class,'to_user');
    }
}
