<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShapeCollection;

class ShapeCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // หรือสร้างกำหนดเอง
        ShapeCollection::create(['collection_code'=>'COL-001','collection_name'=>'Basic Shapes']);

        ShapeCollection::factory()->count(5)->create();
    }
}
