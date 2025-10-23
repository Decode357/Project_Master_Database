<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Shape, Glaze, Pattern, Backstamp};

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
            'file_path' => 'uploads/somewhere/' . $this->faker->unique()->word() . '.jpg',

            // สุ่มเลือก 1 ใน 4 ความสัมพันธ์
            ...match (Arr::random(['shape', 'glaze', 'pattern', 'backstamp'])) {
                'shape' => ['shape_id' => Shape::inRandomOrder()->value('id')],
                'glaze' => ['glaze_id' => Glaze::inRandomOrder()->value('id')],
                'pattern' => ['pattern_id' => Pattern::inRandomOrder()->value('id')],
                'backstamp' => ['backstamp_id' => Backstamp::inRandomOrder()->value('id')],
            },

        ];
    }
}
