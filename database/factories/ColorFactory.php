<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Color>
 */
class ColorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // generate HEX color code เช่น #1A2B3C
            'color_code' => $this->faker->hexcolor(), 
            'color_name' => $this->faker->colorName(),
            'customer_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
