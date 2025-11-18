<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Requestor, Customer, Status, User, Image};

class Backstamp extends Model
{
    use HasFactory;
    protected $fillable = [
        'backstamp_code',
        'name',
        'requestor_id',
        'customer_id',
        'status_id',
        'organic',
        'in_glaze',
        'on_glaze',
        'under_glaze',
        'air_dry',
        'approval_date',
        'updated_by',
        'created_at',
    ];

    protected $casts = [
        'organic' => 'boolean',
        'in_glaze' => 'boolean',
        'on_glaze' => 'boolean',
        'under_glaze' => 'boolean',
        'air_dry' => 'boolean',
        'approval_date' => 'datetime',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function requestor()
    {
        return $this->belongsTo(Requestor::class, 'requestor_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
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
