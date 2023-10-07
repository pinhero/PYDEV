<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $role = $request->user()->role;
        if ($role) {
            switch ($role) {
                case 'ROLE_ADMIN':
                    $request->request->add([
                        'scope' => 'user'
                    ]);
                    break;
                
                case 'ROLE_CLIENT':
                    $request->request->add([
                        'scope' => 'client'
                    ]);
                    break;
                
                default:
                    $request->request->add([
                        'scope' => ''
                    ]);
                    break;
            }
            //set scope based on user role
        }
        return $next($request);
    }
}
