<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{ProductPrice, Product, User};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPrice>
 */
class ProductPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tiers = ['Retail', 'Wholesale', 'Premium', 'Bulk'];
        $currencies = ['THB', 'USD', 'EUR'];

        return [
            'price' => $this->faker->randomFloat(2, 50, 2000), // ราคา 50-2000
            'price_tier' => $this->faker->randomElement($tiers),
            'currency' => $this->faker->randomElement($currencies),
            'effective_date' => $this->faker->dateTimeBetween('-1 year', '+6 months'),
            'product_id' => Product::factory(), // จะสร้าง Product ใหม่ถ้าไม่มี
            'created_by' => User::inRandomOrder()->first()?->id ?? 1,
            'updated_by' => User::inRandomOrder()->first()?->id ?? 1,
        ];
    }

    /**
     * Create current price (effective today)
     */
    public function current()
    {
        return $this->state(function (array $attributes) {
            return [
                'effective_date' => now()->subDays(rand(1, 30)),
            ];
        });
    }

    /**
     * Create future price
     */
    public function future()
    {
        return $this->state(function (array $attributes) {
            return [
                'effective_date' => now()->addDays(rand(1, 180)),
            ];
        });
    }
}
