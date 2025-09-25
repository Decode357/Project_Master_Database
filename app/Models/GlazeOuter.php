<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Color;

class GlazeOuter extends Model
{
    use HasFactory;

    protected $fillable = ['glaze_outer_code'];

    public function colors()
    {
        return $this->belongsToMany(
            Color::class, 
            'color_glaze_outers',
            'glaze_outer_id',
            'color_id'
        );
    }
}
