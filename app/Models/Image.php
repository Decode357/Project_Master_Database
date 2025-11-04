<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name', 'file_path', 'shape_id', 'glaze_id',
        'pattern_id', 'backstamp_id'
    ];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    public function shape()
    {
        return $this->belongsTo(Shape::class, 'shape_id');
    }
    public function glaze()
    {
        return $this->belongsTo(Glaze::class, 'glaze_id');
    }
    public function pattern()
    {
        return $this->belongsTo(Pattern::class, 'pattern_id');
    }
    public function backstamp()
    {
        return $this->belongsTo(Backstamp::class, 'backstamp_id');
    }
}
