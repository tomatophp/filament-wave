<?php

namespace Wave\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'local' => 'required|string',
        ]);

        app()->setLocale($request->get('local'));

        if (session()->has('locale')) {
            session()->forget('locale');
        }

        session()->put('locale', $request->get('local'));

        return back();
    }
}
