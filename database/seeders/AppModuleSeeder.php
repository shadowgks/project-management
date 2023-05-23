<?php

namespace Database\Seeders;

use App\Models\AppModule;
use App\Models\App;
use Illuminate\Database\Seeder;

class AppModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppModule::factory(2)->create();
    }
}
