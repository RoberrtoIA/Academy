<?php

use App\Http\Controllers\V1\AuthController;
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

        Route::resource('programs', ProgramController::class)
            ->except(['index', 'show'])
            ->middleware(['ability:manage_programs']);

        Route::resource('programs', ProgramController::class)
            ->only(['index', 'show'])
            ->middleware([
                'ability:manage_programs'
                    . ',see_program_content_details'
                    . ',see_program_content'
            ]);
    });
});
