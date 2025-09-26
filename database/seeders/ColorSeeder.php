<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
    $colors = config('colors');
        foreach ($colors as $c) {
            Color::firstOrCreate(
                ['color_code' => $c['code']],
                ['color_name' => $c['name'], 'customer_id' => 1]
            );
        }
    }
}
