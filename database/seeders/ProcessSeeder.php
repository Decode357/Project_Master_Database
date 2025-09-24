<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Process;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // หรือสร้างกำหนดเอง
        Process::create(['process_name'=>'Cutting']);
        Process::factory()->count(5)->create();

    }
}
