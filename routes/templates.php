<?php

use Illuminate\Support\Facades\Route;

Route::get('/workspace/{workspace}/templates', function ($workspace) {
    return response()->view('mixpost::templates.window-opener');
})->name('mixpost.templates.index');
