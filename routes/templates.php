<?php

use Illuminate\Support\Facades\Route;

Route::get('/workspace/{workspace}/templates', function ($workspace) {
    return redirect()->away('https://www.google.com');
})->name('mixpost.templates.index');
