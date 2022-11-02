<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\ModuleController;
use App\Http\Controllers\V1\ProgramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::name('api.v1.')->prefix('v1')->group(function () {

    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::resource('programs', ProgramController::class)->middleware(['ability:manager,developer,traineer,trainee']);

        Route::resource('modules', ModuleController::class)->middleware(['ability:manager,developer,traineer,trainee']);
    });
});
