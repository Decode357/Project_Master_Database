<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    GlazeInside,
    GlazeOuter,
    Effect,
};

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'color_code',
        'color_name',
        'customer_id',
    ];
    public function glazeInsides()
    {
        return $this->belongsToMany(
            GlazeInside::class,
            'color_glaze_insides',
            'color_id',
            'glaze_inside_id'
        );
    }

    public function glazeOuters()
    {   
        return $this->belongsToMany(
            GlazeOuter::class, 
            'color_glaze_outers',
            'color_id',
            'glaze_outer_id'
        );
    }
    public function effects()
    {
        return $this->belongsToMany(
            Effect::class,
            'color_effects',
            'color_id',
            'effect_id'
        );
    }
}
