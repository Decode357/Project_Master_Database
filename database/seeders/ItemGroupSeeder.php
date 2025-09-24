<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ItemGroup;

class ItemGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // หรือเพิ่มแบบกำหนดเอง
        ItemGroup::create(['item_group_name' => 'Electronics']);
        ItemGroup::create(['item_group_name' => 'Furniture']);
        // สร้างตัวอย่าง 5 กลุ่ม
        ItemGroup::factory()->count(5)->create();
    }
}
