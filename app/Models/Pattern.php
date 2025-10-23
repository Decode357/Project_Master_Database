<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Requestor, Customer, Status, Designer, User, Image};

class Pattern extends Model
{
    use HasFactory;

    // ถ้าต้องการกำหนดชื่อ table ชัดเจน
    // protected $table = 'patterns';

    // ถ้าอยาก mass assign ทั้งหมด
    protected $fillable = [
        'pattern_code',
        'pattern_name',
        'requestor_id',
        'customer_id',
        'status_id',
        'designer_id',
        'duration',
        'in_glaze',
        'on_glaze',
        'under_glaze',
        'approval_date',
        'updated_by',
    ];

    // ถ้า column เป็น date
    protected $dates = [
        'approval_date',
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
    'approval_date' => 'datetime',
    ];

    // ความสัมพันธ์กับตารางอื่นๆ
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
    public function designer()
    {
        return $this->belongsTo(Designer::class, 'designer_id');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
