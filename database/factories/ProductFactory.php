<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Product, Status, ProductCategory, Shape, Glaze, Pattern, Backstamp, User, Image};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prefixes = ['PRD', 'ITM', 'SKU'];
        $productTypes = [
            'Dinner Plate', 'Salad Plate', 'Soup Bowl', 'Cereal Bowl', 'Coffee Mug', 
            'Tea Cup', 'Saucer', 'Serving Platter', 'Casserole Dish', 'Vase', 
            'Decorative Bowl', 'Pitcher', 'Sugar Bowl', 'Creamer'
        ];

        return [
            'product_sku' => $this->faker->unique()->regexify('[A-Z]{3}-[0-9]{4}'),
            'product_name' => $this->faker->randomElement($productTypes) . ' - ' . $this->faker->words(2, true),
            'status_id' => Status::inRandomOrder()->first()?->id ?? 1,
            'product_category_id' => ProductCategory::inRandomOrder()->first()?->id ?? 1,
            'shape_id' => Shape::inRandomOrder()->first()?->id ?? null,
            'glaze_id' => Glaze::inRandomOrder()->first()?->id ?? null,
            'pattern_id' => Pattern::inRandomOrder()->first()?->id ?? null,
            'backstamp_id' => Backstamp::inRandomOrder()->first()?->id ?? null,
            'created_by' => User::inRandomOrder()->first()?->id ?? 1,
            'updated_by' => User::inRandomOrder()->first()?->id ?? 1,
            'image_id' => Image::inRandomOrder()->first()?->id ?? null,
        ];
    }
}
