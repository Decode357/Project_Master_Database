<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShapeCollection extends Model
{
    use HasFactory;

    protected $fillable = ['collection_code', 'collection_name'];
}
