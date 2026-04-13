<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
    public function update($locale)
    {
        if (!in_array($locale, ['fr', 'en', 'ar'])) {
            abort(404);
        }

        session(['locale' => $locale]);

        return back();
    }
}
