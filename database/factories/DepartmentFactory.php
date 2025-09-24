<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition()
    {
        // สำหรับ Factory ปกติ จะสุ่มชื่อแผนก
        return [
            'name' => $this->faker->unique()->company() // หรือ $this->faker->word()
        ];
    }

    // ถ้าต้องการให้ fix array ก็สามารถทำ method เพิ่มได้
    public function fixed(array $names)
    {
        return $this->state(function () use ($names) {
            return [
                'name' => $this->faker->randomElement($names),
            ];
        });
    }
}
