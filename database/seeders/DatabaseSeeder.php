<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Shape;
use App\Models\Pattern;
use App\Models\Backstamp;
use App\Models\Glaze;
use App\Models\User;
use App\Models\Color;
use App\Models\Effect;
use App\Models\Customer;
use App\Models\Requestor;
use App\Models\Department;

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
            ShapeSeeder::class,
            PatternSeeder::class,
            BackstampSeeder::class,
            GlazeSeeder::class,
            RolesAndPermissionsSeeder::class,
            ColorSeeder::class,
            EffectSeeder::class,
            DepartmentSeeder::class,
            CustomerSeeder::class,
            RequestorSeeder::class,
        ]);
    }
}
