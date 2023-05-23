<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CollectifAccounts\Database\Seeders\CollectifAccountsDatabaseSeeder;
use Modules\CollectifAccountsGroups\Database\Seeders\CollectifAccountsGroupsDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            SettingsSeeder::class,
            AppSeeder::class,
            GateSeeder::class,
            DropdownSeeder::class,
            // CollectifAccountsGroupsDatabaseSeeder::class,
            // CollectifAccountsDatabaseSeeder::class,
            // Modules Seeders
            // RolesSeeder::class,
            // AppModuleSeeder::class,
            // PermissionsSeeder::class,
        ]);
    }
}
