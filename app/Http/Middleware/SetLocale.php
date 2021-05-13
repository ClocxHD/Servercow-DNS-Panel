<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LanguageController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
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
        App::setLocale(LanguageController::getActiveLanguage());

        return $next($request);
    }
}
