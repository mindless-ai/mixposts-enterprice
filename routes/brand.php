<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/workspace/{workspace}/brand-management', function ($workspace) {
        return redirect()->away('https://www.google.com');
    })->name('mixpost.brand-management');
});
