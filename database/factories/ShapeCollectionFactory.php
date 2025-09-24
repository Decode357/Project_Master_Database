<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShapeCollection;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShapeCollection>
 */
class ShapeCollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'collection_code' => $this->faker->unique()->bothify('COL-###'),
            'collection_name' => $this->faker->word(),
        ];
    }
}
