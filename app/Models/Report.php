<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user',
        'to_user',
        'reason',
        'watched'
    ];

    public function from()
    {
        return $this->belongsTo(User::class,'from_user');
    }

    function to()
    {
        return $this->belongsTo(User::class,'to_user');
    }
}
