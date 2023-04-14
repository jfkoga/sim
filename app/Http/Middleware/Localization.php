<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $localesArray = array();
        $available_locales = config('app.available_locales');
        $browserLanguage = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);


        if (Session::has('locale')) {
            $locale = Session::get('locale', App::getLocale());
        } else {
            foreach ($available_locales as $locale) {
                array_push($localesArray, $locale);
            }

            $isFound = in_array($browserLanguage, $localesArray);

            if ($isFound) {
                $locale = $browserLanguage;
            } else {
                $locale = 'ca';
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
