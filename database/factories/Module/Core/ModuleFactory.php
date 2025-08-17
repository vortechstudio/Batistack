<?php

namespace Database\Factories\Module\Core;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module\Core\Module>
 */
class ModuleFactory extends Factory
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
            'description' => $this->faker->sentence,
            'saas_module_id' => $this->faker->numberBetween(1, 100),
            'is_activable' => $this->faker->boolean,
            'active' => $this->faker->boolean,
        ];
    }
}
