<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tier;

class TierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiers = ['Retail', 'Wholesale', 
        'Premium', 'Bulk', 'VIP', 'Standard', 
        'Economy', 'Deluxe'];

        foreach ($tiers as $tier) {
            Tier::firstOrCreate(['name' => $tier]);
        }
    }
}
