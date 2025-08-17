<?php

namespace Database\Factories\Module\Core;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module\Core\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company' => $this->faker->company,
            'license_key' => $this->faker->uuid,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'max_users' => $this->faker->numberBetween(1, 100),
            'max_folders' => $this->faker->numberBetween(1, 100),
            'max_storages' => $this->faker->numberBetween(1, 100),
            'expired_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
