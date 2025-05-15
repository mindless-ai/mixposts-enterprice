<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ExternalRedirectController extends Controller
{
    public function redirect(Request $request, $target)
    {
        $allowedTargets = [
            'google' => 'https://www.google.com',
            'twitter' => 'https://twitter.com',
            'facebook' => 'https://www.facebook.com',
        ];
        
        if (!isset($allowedTargets[$target])) {
            abort(404);
        }
        
        return Redirect::away($allowedTargets[$target]);
    }
}
