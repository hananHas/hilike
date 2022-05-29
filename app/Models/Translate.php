<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'translatable_id',
        'translatable_type'
    ];

    public function translatable()
    {
        return $this->morphTo();
    }
}
