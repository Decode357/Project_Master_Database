<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ItemGroup;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemGroup>
 */
class ItemGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_group_name' => $this->faker->unique()->word(),
        ];
    }
}
