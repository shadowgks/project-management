<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Facades\Agent;

class SessionModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'sessions';

    public static function _save($request, $activity)
    {
        $new_session = new self;
        $new_session->user_id = Auth::id();
        $new_session->ip_address = $request->ip();
        $new_session->payload = $activity;
        $new_session->device = self::getDeviceType();
        $new_session->user_agent = $request->header('User-Agent');
        $new_session->last_activity = 1;
        $new_session->save();
    }

    private static function getDeviceType()
    {
        if (Agent::isDesktop()) {
            return 'Desktop';
        } else if (Agent::isMobile()) {
            return 'Phone';
        } else if (Agent::isTablet()) {
            return 'Tablet';
        } else {
            return 'Not Defined';
        }
    }
}
