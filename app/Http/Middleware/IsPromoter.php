<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsPromoter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $promoter = \App\Models\User::query()->where('id', Auth::id())->first();
        if( !$promoter->hasAnyRole('promoter') ) 
        {
           return response()->json([
                'error' => true,
                'errorMessage' => "Unauthorized access, kindly contact admin"
           ]);
        }
        return $next($request);
    }
}
