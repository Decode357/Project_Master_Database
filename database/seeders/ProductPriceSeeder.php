<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Product, ProductPrice};

class ProductPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            // Create current price for each product
            ProductPrice::factory()
                ->current()
                ->create(['product_id' => $product->id]);

            // 70% chance to have additional price tiers
            if (fake()->boolean(70)) {
                ProductPrice::factory()
                    ->current()
                    ->create([
                        'product_id' => $product->id,
                        'price_tier' => 'Wholesale',
                        'price' => fake()->randomFloat(2, 30, 1500), // Lower wholesale price
                    ]);
            }

            // 30% chance to have future price
            if (fake()->boolean(30)) {
                ProductPrice::factory()
                    ->future()
                    ->create(['product_id' => $product->id]);
            }
        }

        $this->command->info('Product prices created successfully!');
    }
}
