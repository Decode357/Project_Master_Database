<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Dinnerware', 'Serveware', 'Drinkware', 'Decorative', 'Kitchen Utensils',
            'Plates', 'Bowls', 'Cups', 'Saucers', 'Mugs', 'Vases', 'Figurines'
        ];

        return [
            'category_name' => $this->faker->unique()->randomElement($categories),
            'parent_category_id' => null, // Will be set in seeder for hierarchical structure
        ];
    }

    /**
     * Create a child category
     */
    public function child($parentId)
    {
        return $this->state(function (array $attributes) use ($parentId) {
            return [
                'parent_category_id' => $parentId,
            ];
        });
    }
}
