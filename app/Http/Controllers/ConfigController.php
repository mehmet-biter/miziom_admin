<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ConfigController extends Controller
{
    public function configurationPage()
    {
        $data['title'] = __("Configuration");
        return view('configuration.config', $data);
    }

    public function adminRunCommand($type)
    {
        $message = __('Nothing to execute');
        try {
            if($type == COMMAND_TYPE_MIGRATE) {
               Artisan::call('migrate', ['--force' => true ]);
               Artisan::call('db:seed', ['--force' => true ]);
                $message = __('Migrate successfully');
            }
            if($type == COMMAND_TYPE_CACHE) {
               Artisan::call('cache:clear');
                $message = __('Application cache cleared successfully');
            }
            if($type == COMMAND_TYPE_CONFIG) {
               Artisan::call('config:clear');
                $message = __('Application config cleared successfully');
            }
            if($type == COMMAND_TYPE_VIEW || $type == COMMAND_TYPE_ROUTE) {
               Artisan::call('view:clear');
               Artisan::call('route:clear');
                $message = __('Application view cleared successfully');
            }

            if($type == COMMAND_TYPE_SCHEDULE_START) {
                Artisan::queue('schedule:run');
                $message = __('Scheduler started successfully');
            }
       
            
        } catch (\Exception $e) {
            storeException('command exception--> ', $e->getMessage());
            return redirect()->back()->with('dismiss', $e->getMessage());
        }

        return redirect()->back()->with('success', $message);
    }
}
