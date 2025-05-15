<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/workspace/{workspace}/templates', [RedirectController::class, 'redirectToGoogle'])
    ->name('mixpost.templates.index');
