<?php

use App\Http\Controllers\API\V1\CopyController;
use App\Http\Controllers\API\V1\GameController;
use App\Http\Controllers\API\V1\GenreController;
use App\Http\Controllers\API\V1\PlatformController;
use App\Http\Controllers\API\V1\StudioController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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
    // Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::group(['middleware' => 'auth:api'], function(){

    // Genres
    Route::apiResource('/genres', GenreController::class);

    // Studios
    Route::apiResource('/studios', StudioController::class);

    // Platforms
    Route::apiResource('/platforms', PlatformController::class);

    // Games
    Route::apiResource('/games', GameController::class);

    // Users
    Route::apiResource('/users', UserController::class);

    // Copies
    Route::apiResource('/copies', CopyController::class);

});
