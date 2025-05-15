<?php

use Illuminate\Support\Facades\Route;

Route::get('/workspace/{workspace}/templates', function ($workspace) {
    return inertia('Workspace/Templates/Index', [
        'workspace' => $workspace
    ]);
})->name('mixpost.templates.index');
