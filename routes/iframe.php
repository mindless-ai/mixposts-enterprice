<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IframeController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/workspace/{workspace}/iframe/{url?}', [IframeController::class, 'show'])
        ->name('mixpost.iframe');
});
