<?php

namespace App\Helpers;

use Auth;
use Spatie\Activitylog\Models\Activity;

class LogHelper
{
    public static function setLog($action, $modelObject, $description = null, $properties = [])
    {
        $user = Auth::user();
        $new_description = ($description == null ? $action : $description);

        activity()
            ->causedBy($user)
            ->performedOn($modelObject)
            ->event($action)
            ->withProperties($properties)
            ->log($new_description);

        return true;
    }

    public static function getLog($last = false)
    {
        if ($last)
            return Activity::all()->last();
        else
            return Activity::all();
    }
}
