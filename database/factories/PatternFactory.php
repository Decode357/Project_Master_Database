<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Requestor, Customer, Status, Designer, Image};

class PatternFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pattern_code' => 'PT-' . $this->faker->unique()->numberBetween(1000, 9999),
            'pattern_name' => $this->faker->word(),
            'requestor_id' => Requestor::inRandomOrder()->value('id'),
            'customer_id' => Customer::inRandomOrder()->value('id'),
            'status_id' => Status::inRandomOrder()->value('id'),
            'designer_id' => Designer::inRandomOrder()->value('id'),
            'duration' => $this->faker->numberBetween(1, 30),
            'in_glaze' => $this->faker->boolean(),
            'on_glaze' => $this->faker->boolean(),
            'under_glaze' => $this->faker->boolean(),
            'approval_date' => $this->faker->optional()->date(),
            'image_id' => Image::inRandomOrder()->value('id'),
        ];
    }
}
