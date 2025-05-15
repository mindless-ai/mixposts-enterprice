<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/brand-management', function () {
        return inertia('Workspace/BrandManagement');
    })->name('mixpost.brand-management');
});
