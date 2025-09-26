<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{
    GlazeInside,
    GlazeOuter,
    Effect,
    Image,
    Status,
    User,
};

class GlazeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'glaze_code' => 'GZ-' . $this->faker->unique()->numberBetween(1000, 9999),
            'fire_temp' => $this->faker->numberBetween(800, 1300),
            'approval_date' => $this->faker->dateTimeBetween('-1 years', 'now'),

            'status_id' => Status::inRandomOrder()->value('id'),
            'glaze_inside_id' => GlazeInside::inRandomOrder()->value('id'),
            'glaze_outer_id' => GlazeOuter::inRandomOrder()->value('id'),
            'effect_id' => Effect::inRandomOrder()->value('id'),
            'image_id' => Image::inRandomOrder()->value('id'),
            'updated_by' => User::inRandomOrder()->value('id'),
        ];
    }
}
