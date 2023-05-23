<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public static function _get($id = null)
    {
        if ($id == null) {
            return self::orderBy('name')->get();
        } else {
            return self::where('id', $id)->first();
        }
    }

    public static function getByCountry($country_id)
    {
        return self::where('country_id', $country_id)->orderBy('name')->get();
    }
}
