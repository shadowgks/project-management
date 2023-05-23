<?php

namespace App\Helpers;

use App\Mail\AppMail;
use Mail;

class MailHelper
{
    public static function sendMail($content, $to, $subject = 'New Mail')
    {
        Mail::raw($content, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
        return true;
    }

    public static function sendMailView($view, $to, $subject = 'New Mail', $with = [])
    {
        if ($subject == null)
            $subject = __('New Mail');

        Mail::to($to)->send(new AppMail($view, $subject, $with));
        return true;
    }

    public static function getConfigMailView($view, $subject = 'New Mail', $with = [])
    {
        if ($subject == null)
            $subject = __('New Mail');

        return new AppMail($view, $subject, $with);
    }
}
