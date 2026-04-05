<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale');

        if (! $locale && $request->user()) {
            $locale = $request->user()->locale;
            session(['locale' => $locale]);
        }

        if (! in_array($locale, ['fr', 'en'])) {
            $locale = 'fr';
            session(['locale' => $locale]);
        }

        App::setLocale($locale);

        if ($request->user() && $request->user()->locale !== $locale) {
            $request->user()->update(['locale' => $locale]);
        }

        return $next($request);
    }
}
