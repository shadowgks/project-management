<?php

namespace App\Http\Livewire;

use Auth;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Livewire\Component;
use App\Models\Notification;

class GenerateNotification extends Component
{
    public function render()
    {
        return view('livewire.generate-notification');
    }

    public function getUnreadNotifications()
    {
        $user = Auth::user();
        $unread_notifications = $user->unreadNotifications;
        $logs = Activity::where('causer_id', $user->id)->orderByDesc('id')->limit(5)->get();

        return [
            'alerts_count' => count($unread_notifications),
            'alerts_content' => view('layouts.renders.notifications')->with([
                'notifications' => $unread_notifications,
            ])->render(),
            // 'logs_count' => count($logs),
            'logs_content' => view('layouts.renders.notification_logs')->with([
                'logs' => $logs,
            ])->render(),
        ];
    }

    public function setRead(Request $request)
    {
        Notification::_read($request->id);

        return [
            'success' => true,
            'message' => __('notification_seen'),
            'notifications' => $this->getUnreadNotifications(),
        ];
    }
}
