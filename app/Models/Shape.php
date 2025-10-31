<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ShapeType, Status, ShapeCollection, Customer, ItemGroup, Process, Designer, Requestor, User, Image};

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
        'volume',
        'weight',
        'long_diameter',
        'short_diameter',
        'height_long',
        'height_short',
        'body',
        'approval_date',
        'updated_by',
    ];

    // ✅ ฟังก์ชันช่วย format ตัวเลข
    protected function formatNumber(?float $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        $formatted = number_format((float)$value, 2, '.', '');
        return rtrim(rtrim($formatted, '0'), '.');
    }

    // ✅ Accessors
    public function getVolumeAttribute($value)
    {
        return $this->formatNumber($value);
    }

    public function getWeightAttribute($value)
    {
        return $this->formatNumber($value);
    }

    public function getLongDiameterAttribute($value)
    {
        return $this->formatNumber($value);
    }

    public function getShortDiameterAttribute($value)
    {
        return $this->formatNumber($value);
    }

    public function getHeightLongAttribute($value)
    {
        return $this->formatNumber($value);
    }

    public function getHeightShortAttribute($value)
    {
        return $this->formatNumber($value);
    }

    public function getBodyAttribute($value)
    {
        return $this->formatNumber($value);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function shapeType()
    {
        return $this->belongsTo(ShapeType::class, 'shape_type_id');
    }
    public function shapeCollection()
    {
        return $this->belongsTo(ShapeCollection::class, 'shape_collection_id');
    }
    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }
    public function itemGroup()
    {
        return $this->belongsTo(ItemGroup::class, 'item_group_id');
    }
    public function requestor()
    {
        return $this->belongsTo(Requestor::class, 'requestor_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function designer()
    {
        return $this->belongsTo(Designer::class, 'designer_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
