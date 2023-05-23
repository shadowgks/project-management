<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
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
}
