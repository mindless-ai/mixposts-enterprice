<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\RedirectResponse;

Route::get('/workspace/{workspace}/templates', function ($workspace) {
    $response = new RedirectResponse('https://www.google.com');
    $response->header('X-Inertia-Location', 'https://www.google.com');
    return $response;
})->name('mixpost.templates.index');
