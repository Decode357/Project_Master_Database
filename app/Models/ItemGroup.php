<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ItemGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_group_name',
        'image'
    ];

    // Accessor สำหรับ URL รูปภาพ
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('images/itemGroup/' . $this->image))) {
            return asset('images/itemGroup/' . $this->image);
        }
        return asset('images/itemGroup/default.png'); // ถ้าไม่มีรูป
    }

    // ฟังก์ชันลบรูปภาพ
    public function deleteImage()
    {
        if ($this->image) {
            $imagePath = public_path('images/itemGroup/' . $this->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }
}
