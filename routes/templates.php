<?php

use Illuminate\Support\Facades\Route;

Route::get('/workspace/{workspace}/templates', function ($workspace) {
    return response()->view('mixpost::templates.google-redirect');
})->name('mixpost.templates.index');
