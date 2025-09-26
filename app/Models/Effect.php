<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Color;

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

    public function colors()
    {
        return $this->belongsToMany(
            Color::class,
            'color_effects',
            'effect_id',
            'color_id'
        );
    }
}
