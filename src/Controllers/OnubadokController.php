<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class OnubadokController extends Controller
{
    public function changeLanguage($language): \Illuminate\Http\RedirectResponse
    {
        session(['language' => $language]);
        app()->setLocale($language);

        return redirect()->back();
    }
}
