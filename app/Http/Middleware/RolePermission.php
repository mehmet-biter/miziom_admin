<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $user = User::find(Auth::id());
        if($user->role_module == ROLE_SUPER_ADMIN) return $next($request);
        
        $route = app('router')->currentRouteName();
        $actions = roleActionArray();
        $roleItem = '';
        foreach($actions as $item){
            if($item['route'] == $route){
                $roleItem = $item['code'];
            }
        }
        if ($roleItem) {
            
            if (!empty($user->roles->actions)) {
                $tasks = array_filter(explode('|', $user->roles->actions));
                if (isset($tasks)) {
                    if (in_array($roleItem, $tasks)) {
                        return $next($request);
                    } 
                }
            }
        }
        
        return redirect()->route('adminDashboard')->with('dismiss',__('Access denied'));
    }
}
