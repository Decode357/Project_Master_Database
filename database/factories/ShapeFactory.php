<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShapeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'item_code' => $this->faker->unique()->bothify('SH-###'),
            'item_description_thai' => $this->faker->words(3, true),
            'item_description_eng' => $this->faker->sentence(3),
            'shape_type_id' => 1,
            'status_id' => 1,
            'shape_collection_id' => null,
            'customer_id' => null,
            'item_group_id' => null,
            'process_id' => null,
            'designer_id' => null,
            'requestor_id' => null,
            'image_id' => null,
            'volume' => $this->faker->numberBetween(100, 1000),
            'weight' => $this->faker->numberBetween(10, 500),
            'long_diameter' => $this->faker->numberBetween(10, 100),
            'short_diameter' => $this->faker->numberBetween(10, 100),
            'height_long' => $this->faker->numberBetween(10, 100),
            'height_short' => $this->faker->numberBetween(10, 100),
            'body' => $this->faker->numberBetween(1, 10),
            'approval_date' => $this->faker->date(),
        ];
    }
}
