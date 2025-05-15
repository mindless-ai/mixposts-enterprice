<?php

use Illuminate\Support\Facades\Route;

Route::get('/workspace/{workspace}/templates', function ($workspace) {
    header('Location: https://www.google.com');
    exit;
})->name('mixpost.templates.index');
