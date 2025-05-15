<?php

use Illuminate\Support\Facades\Route;

Route::get('/workspace/{workspace}/templates', function ($workspace) {
    return view('mixpost::templates.index');
})->name('mixpost.templates.index');
