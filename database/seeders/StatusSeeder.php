<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Approved',
            'Pending',
            'Rejected',
            'In Progress',
            'On Hold',
            'Cancelled',
            'Completed',
            'Draft',
        ];
        foreach ($statuses as $status) {
            Status::firstOrCreate(['status' => $status]);
        }
    }
}
