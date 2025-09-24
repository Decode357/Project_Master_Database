<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShapeType;

class ShapeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // หรือเพิ่มแบบกำหนดเอง
        ShapeType::create(['name' => 'Circle']);
        ShapeType::create(['name' => 'Square']);

        // สร้างตัวอย่าง 5 ประเภท
        ShapeType::factory()->count(5)->create();
    }
}
