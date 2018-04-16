<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Exception;

class Language
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
        $uriCheck = Request::segments();

        try {

            if (count($uriCheck) > 0) {
                $local = $uriCheck[0];

                $language = \App\Language::where('short', '=', $local)
                    ->where('enabled', '=', 1)
                    ->first();
            }
            if (!isset($language)) {
                if (\App\Language::getDefaultLanguage()) {
                    \App::setLocale(\App\Language::getDefaultLanguage());
                } else {
                    \App::setLocale(\App\Language::getNextFirstAvailableLanguage());
                }
            }


            if (! \App\Language::checkIfLangAvailable(\App::getLocale())) {
                \App::setLocale(\App\Language::getNextFirstAvailableLanguage());

                $uri = Request::segments();
                $failedLocal = array_shift($uri);

                return redirect()->to(url(\App::getLocale() . '/' . implode('/', $uri)));
            }

            return $next($request);

        } catch (Exception $exception) {
            return Response::redirectTo('/install');

        }

    }
}
