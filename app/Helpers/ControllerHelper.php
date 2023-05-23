<?php

namespace App\Helpers;

use DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ControllerHelper
{
    public static function getController($name, $livewire = false)
    {
        if ($livewire)
            $model = 'App\Http\Livewire\\' . Str::studly($name);
        else
            $model = 'App\Http\Controllers\\' . Str::studly($name);

        return new $model;
    }

    public static function getControllerString($name, $livewire = false)
    {
        if ($livewire)
            $model = 'App\Http\Livewire\\' . Str::studly($name);
        else
            $model = 'App\Http\Controllers\\' . Str::studly($name);

        return $model;
    }

    public static function getControllerName($name)
    {
        $model = Str::studly($name);
        return $model;
    }
}
