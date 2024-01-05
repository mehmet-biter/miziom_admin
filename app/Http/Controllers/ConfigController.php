<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function configurationPage()
    {
        $data['title'] = __("Configuration");
        return view('admin.settings.config', $data);
    }
}
