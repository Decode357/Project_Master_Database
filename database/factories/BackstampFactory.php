<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BackstampFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'backstamp_code' => 'BS-' . $this->faker->unique()->numberBetween(1000, 9999),
            'name' => $this->faker->word(),
            'requestor_id' => $this->faker->numberBetween(1, 5),
            'customer_id' => $this->faker->numberBetween(1, 5),
            'status_id' => $this->faker->numberBetween(1, 3),
            'duration' => $this->faker->numberBetween(1, 30),
            'in_glaze' => $this->faker->boolean(),
            'on_glaze' => $this->faker->boolean(),
            'under_glaze' => $this->faker->boolean(),
            'air_dry' => $this->faker->boolean(),
            'approval_date' => $this->faker->optional()->date(),
            'image_id' => $this->faker->optional()->numberBetween(1, 10),
        ];
    }
}
