<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Product, User};

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'price_tier',
        'currency',
        'effective_date',
        'product_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'effective_date' => 'date',
        'product_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopeCurrent($query)
    {
        return $query->whereDate('effective_date', '<=', now())
                    ->orderBy('effective_date', 'desc');
    }

    public function scopeByTier($query, $tier)
    {
        return $query->where('price_tier', $tier);
    }

    public function scopeByCurrency($query, $currency)
    {
        return $query->where('currency', $currency);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' ' . ($this->currency ?? 'THB');
    }
}
