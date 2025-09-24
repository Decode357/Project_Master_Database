<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Effect extends Model
{
    use HasFactory;

        protected $fillable = [
        'effect_code',
        'effect_name',
        'colors',
    ];
    
    protected $casts = [
        'colors' => 'array', // แปลง JSON เป็น array อัตโนมัติ
    ];
}
