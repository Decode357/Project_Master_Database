<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Requestor, Customer, Status, Designer, User};

class PatternFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ceramicPatterns = [
            'Floral',
            'Geometric',
            'Abstract',
            'Traditional Thai',
            'Mandala',
            'Blue & White',
            'Minimalist',
            'Rustic Texture',
            'Gold Trim',
        ];

        return [
            'pattern_code' => 'PT-' . $this->faker->unique()->numberBetween(1000, 9999),
            'pattern_name' => $this->faker->randomElement($ceramicPatterns),
            'requestor_id' => Requestor::inRandomOrder()->value('id'),
            'customer_id' => Customer::inRandomOrder()->value('id'),
            'status_id' => Status::inRandomOrder()->value('id'),
            'designer_id' => Designer::inRandomOrder()->value('id'),
            'exclusive' => $this->faker->boolean(),
            'in_glaze' => $this->faker->boolean(),
            'on_glaze' => $this->faker->boolean(),
            'under_glaze' => $this->faker->boolean(),
            'approval_date' => $this->faker->optional()->date(),
            'updated_by' => User::inRandomOrder()->value('id'),
        ];
    }
}
