<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/workspace/{workspace}/brand-management', function ($workspace) {
        return redirect()->away("https://redalien-saas-e9b65554.railway.internal/brand-management?workspace={$workspace}");
    })->name('mixpost.brand-management');
});
