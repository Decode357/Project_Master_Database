<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Design',
            'Engineering',
            'IT',
            'Sales',
            'Marketing',
            'HR',
            'Finance',
            'Production',
            'Quality Assurance',
            'Customer Support',
            'Logistics',
            'Research & Development',
            'Administration'
        ];

        foreach ($departments as $depName) {
            Department::factory()->create([
                'name' => $depName
            ]);
        }
    }
}
