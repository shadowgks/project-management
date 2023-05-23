<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notification::create([
            'slug' => "Notification-slug-1",
            'description' => "Notification description",
        ]);
        
        Notification::create([
            'slug' => "Notification-slug-2",
            'description' => "Notification description",
        ]);
    }
}
