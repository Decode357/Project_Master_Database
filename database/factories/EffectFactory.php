<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Effect>
 */
class EffectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'effect_code' => 'EF-' . $this->faker->unique()->numerify('###'),
            'effect_name' => $this->faker->word(),
            'colors' => $this->faker->randomElements(
                ['#FF0000', '#00FF00', '#0000FF', '#FFA500', '#800080', '#FFFF00'],
                rand(1, 3) // เลือกสุ่ม 1-3 สี
            ),
        ];
    }
}
