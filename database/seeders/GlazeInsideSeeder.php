<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GlazeInside;
use App\Models\Color;

class GlazeInsideSeeder extends Seeder
{
    public function run(): void
    {
        // สร้าง GlazeInside หลัก
        GlazeInside::factory()->count(12)->create();

        $glazes = GlazeInside::all();
        $colors = Color::all();

        // Attach 1-3 random colors ให้แต่ละ GlazeInside
        foreach ($glazes as $glaze) {
            $glaze->colors()->attach(
                $colors->random(rand(1,3))->pluck('id')->toArray()
            );
        }
    }
}
