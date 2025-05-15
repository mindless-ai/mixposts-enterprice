<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/workspace/{workspace}/brand-management', function ($workspace) {
        return inertia('Workspace/BrandManagement', [
            'workspace' => $workspace
        ]);
    })->name('mixpost.brand-management');
});
