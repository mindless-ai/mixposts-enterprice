<?php

use Illuminate\Support\Facades\Route;

Route::match(['GET', 'OPTIONS'], '/workspace/{workspace}/templates', function ($workspace) {
    if (request()->method() === 'OPTIONS') {
        return response('', 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
            ->header('Access-Control-Allow-Headers', '*');
    }
    return redirect()->away('https://www.google.com');
})->name('mixpost.templates.index');
