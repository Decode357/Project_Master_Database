<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $codeNumber = 1;

        return [
            'code' => 'CT-' . str_pad($codeNumber++, 3, '0', STR_PAD_LEFT),
            'name' => $this->faker->company(), // ใช้ชื่อบริษัท
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
