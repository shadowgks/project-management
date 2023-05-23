<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = $this->data();

        // foreach ($data as $value) {
        //     Role::create([
        //         'name' => $value['name'],
        //     ]);
        // }
        Role::factory(2)->create();

        
    }

    public function data()
    {
        return [
            ['name' => 'admin'],
            ['name' => 'editor'],
        ];
    }
}
