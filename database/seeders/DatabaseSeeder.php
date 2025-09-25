<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\{
    Shape,
    Pattern,
    Backstamp,
    Glaze,
    User,
    Color,
    Effect,
    Customer,
    Requestor,
    Department,
    ItemGroup,
    ShapeType,
    ShapeCollection,
    Process,
    Status,
    Designer,
    Image
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
                // ลบข้อมูลตามลำดับความสัมพันธ์
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Customer::truncate();
        Requestor::truncate();
        Department::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Color::truncate();
        Effect::truncate();
        Glaze::truncate();
        Backstamp::truncate();
        Pattern::truncate();
        Shape::truncate();
        // เรียกใช้ seeders ตามลำดับความสัมพันธ์
        $this->call([
            
            
            RolesAndPermissionsSeeder::class,
            ColorSeeder::class,
            EffectSeeder::class,
            DepartmentSeeder::class,
            CustomerSeeder::class,
            RequestorSeeder::class,
            ItemGroupSeeder::class,
            ShapeTypeSeeder::class,
            ShapeCollectionSeeder::class,
            ProcessSeeder::class,
            StatusSeeder::class,
            DesignerSeeder::class,
            ImageSeeder::class,
            
            
            // table ที่มี foreign key ไปยัง table อื่นๆ ควรอยู่ท้ายสุด
            BackstampSeeder::class,
            PatternSeeder::class,
            GlazeSeeder::class,
            ShapeSeeder::class,
        ]);
    }
}
