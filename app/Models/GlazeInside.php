<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Color;

class GlazeInside extends Model
{
    use HasFactory;

    protected $fillable = ['glaze_inside_code'];

    public function colors()
    {
        return $this->belongsToMany(
            Color::class,          // Model ที่เชื่อม
            'color_glaze_insides', // Pivot table
            'glaze_inside_id',     // FK ของ GlazeInside ใน pivot
            'color_id'             // FK ของ Color ใน pivot
        );
    }

}

