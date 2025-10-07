<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Status, ProductCategory, Shape, 
    Glaze, Pattern, Backstamp, 
    User, ProductPrice, Image
};

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_sku',
        'product_name',
        'status_id',
        'product_category_id',
        'shape_id',
        'glaze_id',
        'pattern_id',
        'backstamp_id',
        'created_by',
        'updated_by',
        'image_id',
    ];

    protected $casts = [
        'status_id' => 'integer',
        'product_category_id' => 'integer',
        'shape_id' => 'integer',
        'glaze_id' => 'integer',
        'pattern_id' => 'integer',
        'backstamp_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'image_id' => 'integer',
    ];

    // Relationships
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }


    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function currentPrice()
    {
        return $this->hasOne(ProductPrice::class, 'product_id')
                    ->whereDate('effective_date', '<=', now())
                    ->orderBy('effective_date', 'desc');
    }
}
