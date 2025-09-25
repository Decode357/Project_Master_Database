<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_name' => $this->faker->unique()->word() . '.jpg',
            'file_path' => 'uploads/shapes/' . $this->faker->unique()->word() . '.jpg',
            'mime_type' => 'image/jpeg',
            'size' => $this->faker->numberBetween(1000, 500000), // ขนาดไฟล์ระหว่าง 1KB ถึง 500KB
        ];
    }
}
