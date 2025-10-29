<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Effect;
use App\Models\Color;

class EffectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Effect::factory(32)->create();

        $effects = Effect::all();
        $colors = Color::all();

        foreach ($effects as $effect) {
            $effect->colors()->attach(
                $colors->random(rand(0,3))->pluck('id')->toArray()
            );
        }
    }
}
