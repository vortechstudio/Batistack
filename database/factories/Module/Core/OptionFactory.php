<?php

namespace Database\Factories\Module\Core;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module\Core\Option>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence,
            'is_enabled' => $this->faker->boolean,
            'expires_at' => $this->faker->date,
            'active' => $this->faker->boolean,
        ];
    }
}
