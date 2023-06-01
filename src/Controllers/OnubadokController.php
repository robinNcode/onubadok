<?php namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

/**
 * Class OnubadokController
 * @package App\Http\Controllers
 * @property string $language
 * @generated_by Robinncode\Onubadok
 */
class OnubadokController extends Controller
{
    /**
     * To change the language ...
     * @param $language
     * @return RedirectResponse
     */
    public function change($language): RedirectResponse
    {
        session(['language' => $language]);
        return redirect()->to('/');
    }
}
