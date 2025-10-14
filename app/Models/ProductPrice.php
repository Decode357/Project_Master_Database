<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Product, User, Currency, Tier};

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'tier_id',
        'currency_id',
        'effective_date',
        'product_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'effective_date' => 'date',
        'tier_id' => 'integer',
        'currency_id' => 'integer',
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

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'tier_id');
    }
}
