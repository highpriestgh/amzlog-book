<?php

namespace App\Http\Middleware;

use Closure;

class CheckCompanyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        session_start();
        if ((!isset($_SESSION['company_id']) && !isset($_SESSION['company_email']))) {
            return redirect('/');
        }
        return $next($request);
    }
}
