<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class RequiredURLparameter
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
        $available_locales = config('app.available_locales');

        if ($request->filled('user')) {
            $input = strtolower($request->input('user'));

            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                echo "Something's wrong with the email format";
                abort(403);
            }

            if ($request->filled('lang')) {
                $value = $request->input('lang');
                if (in_array($value, $available_locales)){
                    $this->setLang($value);
                }else{
                    $this->setLang('ca');
                }
            }else{
                if (Session::has('locale')) {
                    $locale = Session::get('locale', App::getLocale());
                    $this->setLang($locale);
                }else{
                    $this->setLang('ca');
                }
            }

            session()->put('locale', App::getLocale());

            return $next($request);
        } else {
            echo "USER parameter missing in URL";
            abort(404);
        }
    }

    public function setLang(string $lang){
        App::setLocale($lang);
    }
}
