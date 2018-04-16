<?php

namespace App\Http\Middleware;

use Auth;
use Closure;



class ForceLogout
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


        if (Auth::check()) {
            $user = Auth::user();

            // You might want to create a method on your model to
            // prevent direct access to the `logout` property. Something

            if ($user->enabled == 2) {

                // Log her out
                Auth::logout();

                return redirect()->route('login');
            }
        }


        return $next($request);
    }
}
