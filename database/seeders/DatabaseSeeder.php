<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
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
    Image,
    GlazeInside,
    GlazeOuter,
};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ปิด FK constraints ชั่วคราว
        Schema::disableForeignKeyConstraints();

        // truncate pivot tables ก่อน (ต้องลบก่อน parent)
        \DB::table('color_glaze_insides')->truncate();
        \DB::table('color_glaze_outers')->truncate();
        \DB::table('color_effects')->truncate();

        // truncate หลัก
        User::truncate();
        Customer::truncate();
        Requestor::truncate();
        Department::truncate();
        Color::truncate();
        Effect::truncate();
        Glaze::truncate();
        Backstamp::truncate();
        Pattern::truncate();
        Shape::truncate();
        ShapeType::truncate();
        ShapeCollection::truncate();
        Process::truncate();
        Status::truncate();
        Designer::truncate();
        Image::truncate();
        GlazeInside::truncate();
        GlazeOuter::truncate();
        ItemGroup::truncate();

        Schema::enableForeignKeyConstraints();

        // เรียกใช้ seeders ตามลำดับ
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
            GlazeOuterSeeder::class,
            GlazeInsideSeeder::class,
            BackstampSeeder::class,
            PatternSeeder::class,
            GlazeSeeder::class,
            ShapeSeeder::class,
        ]);
    }
}
