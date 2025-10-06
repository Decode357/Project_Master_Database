<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'category_name',
        'parent_category_id',
    ];

    protected $casts = [
        'parent_category_id' => 'integer',
    ];

    // Self-referencing relationship
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_category_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_category_id');
    }

    // Products in this category
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Get all descendants (recursive)
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    // Get path from root to this category
    public function getPathAttribute()
    {
        $path = collect([$this->category_name]);
        $parent = $this->parent;
        
        while ($parent) {
            $path->prepend($parent->category_name);
            $parent = $parent->parent;
        }
        
        return $path->implode(' > ');
    }
}
