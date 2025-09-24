<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shape extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code',
        'item_description_thai',
        'item_description_eng',
        'shape_type_id',
        'status_id',
        'shape_collection_id',
        'customer_id',
        'item_group_id',
        'process_id',
        'designer_id',
        'requestor_id',
        'image_id',
        'volume',
        'weight',
        'long_diameter',
        'short_diameter',
        'height_long',
        'height_short',
        'body',
        'approval_date',
    ];
}
