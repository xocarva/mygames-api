<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Copy>
 */
class CopyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'     => $attribute['user_id'] ?? User::factory(),
            'game_id'     => $attribute['game_id'] ?? Game::factory(),
            'platform_id' => $attribute['platform_id'] ?? Platform::factory(),
            'rating'      => $this->faker->numberBetween(0,5),
            'completed'   => $this->faker->boolean,
        ];
    }
}
