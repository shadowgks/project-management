<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->data();

        foreach ($data as $value) {
            Setting::create([
                'key' => $value['key'],
                'value' => $value['value'],
            ]);
        }

    }

    private function data()
    {
        return [
            ['key' => 'app_name', 'value' => 'Algobridge'],
            ['key' => 'app_logo', 'value' => ''],
            ['key' => 'app_dark_logo', 'value' => ''],
            ['key' => 'app_favicon', 'value' => ''],
            ['key' => 'theme', 'value' => 'demo1'],
            ['key' => 'app_language', 'value' => 'en'],
            ['key' => 'app_date_format', 'value' => ''],
            ['key' => 'app_timezone', 'value' => ''],
            ['key' => 'company_name', 'value' => ''],
            ['key' => 'company_address', 'value' => ''],
            ['key' => 'company_area', 'value' => ''],
            ['key' => 'company_city', 'value' => ''],
            ['key' => 'company_country', 'value' => ''],
            ['key' => 'company_zip', 'value' => ''],
            ['key' => 'company_lat', 'value' => ''],
            ['key' => 'company_lng', 'value' => ''],
            ['key' => 'company_tel', 'value' => ''],
            ['key' => 'company_phone', 'value' => ''],
            ['key' => 'company_fax', 'value' => ''],
        ];
    }
}
