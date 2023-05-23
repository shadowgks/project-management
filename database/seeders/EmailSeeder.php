<?php

namespace Database\Seeders;

use App\Models\Email;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Email::create([
            'slug' => "Email-slug-1",
            'description' => "Email description", 
        ]);
        Email::create([
            'slug' => "Email-slug-2",
            'description' => "Email description", 
        ]);


    }
}
