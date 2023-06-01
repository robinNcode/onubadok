<?php

namespace Robinncode\Onubadok\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

/**
 * Class Controller
 * @package App\Http\Controllers
 * @generated_by Robinncode\Onubadok
 * @property string $language
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (session()->has('language')) {
                App::setLocale(session()->get('language'));
            }
            return $next($request);
        });
    }
}
