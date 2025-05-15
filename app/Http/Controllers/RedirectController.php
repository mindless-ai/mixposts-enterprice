<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirectToGoogle()
    {
        return response()->view('redirect', [
            'url' => 'https://www.google.com'
        ]);
    }
}
