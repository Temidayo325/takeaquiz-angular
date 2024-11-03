<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    	$admin = \App\Models\User::query()->where('id', Auth::id())->first();
        if( !$admin->hasAnyRole('admin') ) 
        {
           redirect('/user/dashboard');
        }
        return $next($request);
    }
}
