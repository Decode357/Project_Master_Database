<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GlazeOuter;
use App\Models\Color;

class GlazeOuterSeeder extends Seeder
{
    public function run(): void
    {
        // สร้าง GlazeOuter หลัก
        GlazeOuter::factory()->count(16)->create();

        $glazes = GlazeOuter::all();
        $colors = Color::all();

        // Attach 1-3 random colors ให้แต่ละ GlazeOuter
        foreach ($glazes as $glaze) {
            $glaze->colors()->attach(
                $colors->random(rand(1,3))->pluck('id')->toArray()
            );
        }
    }
}
