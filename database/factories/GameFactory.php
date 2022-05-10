<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Studio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'genre_id' => $attribute['genre_id'] ?? Genre::factory(),
            'studio_id' => $attribute['studio_id'] ?? Studio::factory()
        ];
    }
}
