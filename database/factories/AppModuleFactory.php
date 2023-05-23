<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModule>
 */
class AppModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
            return [
                'name'              => $this->faker->unique()->randomElement(['Projects', 'Invoices', 'Estimates']),
                'pseudo_name'       => $this->faker->randomElement(['pseudo_name']),
                'empty_when_reinitializating'          => true,
                'emailing'          => true,
                'notifications'          => true,
                'pdf'          => true,
                'contain_validator'          => true,
                'activate_importation'          => true,
                'activate_file_upload'          => true,
                'activate_comments'          => true,
                'activate_reminders'          => true,
                'activate_duplicate'          => true,
                'namespace'          => 'namespace',
                'gate_id'          => 1,
                'app_id'          => 1,
                'active'          => true,
                'user_id'           => 1,
            ];
    }
}
