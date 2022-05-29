<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function translate()
    {
        return $this->morphOne(Translate::class, 'translatable');
    }
}
