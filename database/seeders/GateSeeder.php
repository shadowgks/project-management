<?php

namespace Database\Seeders;

use App\Models\Gate;
use Illuminate\Database\Seeder;

class GateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gate::create([
            'name' => "admin",
            'prefix' => "AD",
            'app_id' => 1,
            'user_id' => 1,
        ]);
    }
}
