<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GlazeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'glaze_code' => 'GZ-' . $this->faker->unique()->numberBetween(1000, 9999),
            'status_id' => $this->faker->numberBetween(1, 3),
            'fire_temp' => $this->faker->numberBetween(800, 1300),
            'approval_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'glaze_inside_id' => $this->faker->numberBetween(1, 10),
            'glaze_outer_id' => $this->faker->numberBetween(1, 10),
            'effect_id' => $this->faker->numberBetween(1, 10),
            'image_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
