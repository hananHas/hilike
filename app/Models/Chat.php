<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_user',
        'second_user',
        'thread_id',
    ];

    public function f_user()
    {
        return $this->belongsTo(User::class,'first_user');
    }

    public function s_user()
    {
        return $this->belongsTo(User::class,'second_user');
    }

    public function category()
    {
        return $this->belongsTo(ChatCategory::class,'chat_category_id');
    }
}
