<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->utype=='ADM'){
                return $next($request);
            }else{
                session::flush();/*đăng xuất hoàn toàn*/
                return redirect('/')->route('login');
            }
        return $next($request);
        }
        else{
            return redirect('/')->route('login')->with('status',"Please Login to access Admin Dashboard");
        }
    }
}