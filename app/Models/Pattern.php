<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'image_id',
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
}
