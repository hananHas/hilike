<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'image',
        'price',
        'gift_category_id',
    ];

    use HasFactory;

    public function category()
    {
        return $this->belongsTo(GiftCategory::class,'gift_category_id');
    }
}
