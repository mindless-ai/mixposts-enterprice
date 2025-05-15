<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IframeController extends Controller
{
    public function show($url = null)
    {
        // Default to Google if no URL is provided
        $url = $url ?? 'https://www.google.com';
        
        // You can add further validation or restrictions here
        return view('mixpost::iframe', compact('url'));
    }
}
