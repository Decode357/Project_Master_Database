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
        'updated_by',
    ];

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
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
