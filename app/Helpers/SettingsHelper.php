<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    public static function get_settings($key)
    {
        return Setting::where('key', $key)->first();
    }

    public static function get_many_settings($keys)
    {
        $arrayHelper = [];
        $settings = Setting::whereIn('key', $keys)->get()->toArray();

        foreach ($settings as $row) {
            $arrayHelper[$row['key']] = $row;
        }

        return $arrayHelper;
    }

    public static function get_supported_data($key)
    {
        switch ($key) {
            case 'communications':
                return [
                    [
                        'id' => 1,
                        'name' => 'Email',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Phone',
                    ],
                ];
                break;

            default:
                // 
                break;
        }
    }
}
