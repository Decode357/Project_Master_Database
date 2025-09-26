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
        $processes = [
            'Clay Preparation',
            'Shaping',
            'Drying',
            'Bisque Firing',
            'Glazing',
            'Glaze Firing',
            'Decoration',
            'Quality Control',
            'Packing',
        ];
        foreach ($processes as $process) {
            Process::firstOrCreate(['process_name' => $process]);
        }
    }
}
