<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShapeType;
use App\Models\ShapeCollection;
use App\Models\Customer;
use App\Models\ItemGroup;
use App\Models\Process;
use App\Models\Requestor;

class ShapeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'item_code' => $this->faker->unique()->bothify('SH-###'),
            'item_description_thai' => $this->faker->words(3, true),
            'item_description_eng' => $this->faker->sentence(3),

'shape_type_id' => ShapeType::inRandomOrder()->value('id'),
'shape_collection_id' => ShapeCollection::inRandomOrder()->value('id'),
'customer_id' => Customer::inRandomOrder()->value('id'),
'item_group_id' => ItemGroup::inRandomOrder()->value('id'),
'process_id' => Process::inRandomOrder()->value('id'),
'requestor_id' => Requestor::inRandomOrder()->value('id'),

            'status_id' => null,
            'designer_id' => null,
            'image_id' => null,
            'volume' => $this->faker->numberBetween(100, 1000),
            'weight' => $this->faker->numberBetween(10, 500),
            'long_diameter' => $this->faker->numberBetween(10, 100),
            'short_diameter' => $this->faker->numberBetween(10, 100),
            'height_long' => $this->faker->numberBetween(10, 100),
            'height_short' => $this->faker->numberBetween(10, 100),
            'body' => $this->faker->numberBetween(1, 10),
            'approval_date' => $this->faker->date(),
        ];
    }
}
