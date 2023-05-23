<?php

namespace App\Http\Controllers;

use App\Core\Adapters\Theme;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {
        $themes = Theme::getOption('product', 'demos');

        $themes = array_filter($themes, function ($demo) {
            return $demo['published'] == true;
        });
        return view('settings.index', compact('themes'));
    }

    public function updateSettings(Request $request){


        
    }
}
