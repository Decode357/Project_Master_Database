<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Color;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Color>
 */
class ColorFactory extends Factory
{
    public function definition(): array
    {
        $colors = config('colors');

        $color = $this->faker->randomElement($colors);

        return [
            'color_code' => $color['code'],
            'color_name' => $color['name'],
            'customer_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
