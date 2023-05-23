<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'              => $this->faker->unique()->randomElement(['view', 'view_own','edit','delete']),
            'pseudo_name'       => $this->faker->randomElement(['pseudo_name']),
            'category'          => 'module',
            'user_id'           => 1,
        ];
    }
}
