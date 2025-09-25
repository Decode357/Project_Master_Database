<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    GlazeInside,
    GlazeOuter,
};

class Glaze extends Model
{
    use HasFactory;

    protected $table = 'glazes';

    protected $fillable = [
        'glaze_code',
        'status_id',
        'fire_temp',
        'approval_date',
        'glaze_inside_id',
        'glaze_outer_id',
        'effect_id',
        'image_id',
    ];

    protected $casts = [
        'approval_date' => 'datetime',
        'fire_temp' => 'integer',
        'status_id' => 'integer',
        'glaze_inside_id' => 'integer',
        'glaze_outer_id' => 'integer',
        'effect_id' => 'integer',
        'image_id' => 'integer',
    ];

    public function glazeInside()
    {
        return $this->belongsTo(GlazeInside::class, 'glaze_inside_id');
    }
    public function glazeOuter()
    {
        return $this->belongsTo(GlazeOuter::class, 'glaze_outer_id');
    }

}
