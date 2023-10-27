<?php

use App\Http\Controllers\Api\v1\ServerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->name('v1.')->group(function () {
    Route::prefix('servers')->name('servers.')->controller(ServerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
