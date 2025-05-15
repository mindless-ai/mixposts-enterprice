<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExternalRedirectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->to(config('mixpost.core_path'));
});

// External redirect route - no CORS issues as it's a server-side redirect
Route::get('/external/{target}', [ExternalRedirectController::class, 'redirect'])->name('external.redirect');
