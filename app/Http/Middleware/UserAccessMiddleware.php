<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    public function handle(Request $request, Closure $next, $userType): Response
    {
        // return $next($request);
        if(Auth::user()->role == $userType){
            return $next($request);
        }

        return response()->json([
            'error' => 'Hanya admin yang bisa menghapus data ini!',
            'userType'=>$userType
        ]);
    }
}
