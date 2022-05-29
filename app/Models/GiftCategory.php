<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function translate()
    {
        return $this->morphOne(Translate::class, 'translatable');
    }

    public function gifts()
    {
        return $this->hasMany(Gift::class,'gift_category_id');
    }
}
