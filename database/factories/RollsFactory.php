<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Roll>
 */
class RollsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{

        $dice1 = $this->faker->numberBetween(1, 6);
        $dice2 = $this->faker->numberBetween(1, 6);
        $total = $dice1 + $dice2;
        $winner = $total == 7 ? true : false;
        
        return [
        'dice1'=> $dice1,
        'dice2'=> $dice2,
        'total'=> $total,
        'winner'=> $winner,
        'user_id'=> UserFactory::factory()
        ];
    }
}
