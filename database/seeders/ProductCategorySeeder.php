<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Main Categories (Parent Categories)
        $mainCategories = [
            'Dinnerware' => ['Plates', 'Bowls', 'Cups & Mugs', 'Accessories'],
            'Serveware' => ['Serving Platters', 'Serving Bowls', 'Pitchers', 'Casseroles'],
            'Drinkware' => ['Coffee Mugs', 'Tea Cups', 'Water Glasses', 'Wine Glasses'],
            'Decorative' => ['Vases', 'Figurines', 'Decorative Bowls', 'Art Pieces'],
            'Kitchen Utensils' => ['Cooking Tools', 'Serving Utensils', 'Storage', 'Bakeware']
        ];

        foreach ($mainCategories as $mainCategory => $subCategories) {
            // Create main category
            $parent = ProductCategory::create([
                'category_name' => $mainCategory,
                'parent_category_id' => null,
            ]);

            // Create sub-categories
            foreach ($subCategories as $subCategory) {
                ProductCategory::create([
                    'category_name' => $subCategory,
                    'parent_category_id' => $parent->id,
                ]);
            }
        }

        // Create some additional random categories
        ProductCategory::factory(5)->create();

        $this->command->info('Product categories created successfully!');
    }
}
