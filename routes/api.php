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

//Public

Route::controller(GenreController::class)->group(function () {
    Route::get('genres', 'index');
    Route::get('genres/{genre}', 'show');
});

Route::controller(StudioController::class)->group(function () {
    Route::get('studios', 'index');
    Route::get('studios/{studio}', 'show');
});

Route::controller(PlatformController::class)->group(function () {
    Route::get('platforms', 'index');
    Route::get('platforms/{platform}', 'show')->name('platforms.show');
});

Route::controller(GameController::class)->group(function () {
    Route::get('games', 'index');
    Route::get('games/{game}', 'show')->name('games.show');
});


// Admin

Route::group(['middleware' => 'auth:api', 'middleware' => 'isAdmin'], function(){

    Route::controller(GenreController::class)->group(function () {
        Route::post('genres', 'store');
        Route::patch('genres/{genre}', 'update');
        Route::delete('genres/{genre}', 'destroy');
    });

    Route::controller(StudioController::class)->group(function () {
        Route::post('studios', 'store');
        Route::patch('studios/{studio}', 'update');
        Route::delete('studios/{studio}', 'destroy');
    });

    Route::controller(PlatformController::class)->group(function () {
        Route::post('platforms', 'store');
        Route::patch('platforms/{platform}', 'update');
        Route::delete('platforms/{platform}', 'destroy');
    });

    Route::controller(GameController::class)->group(function () {
        Route::post('games', 'store');
        Route::patch('games/{game}', 'update');
        Route::delete('games/{game}', 'destroy');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index');
        Route::get('users/{user}', 'show')->name('users.show');
        Route::post('users', 'store');
        Route::patch('users/{user}', 'update');
        Route::delete('users/{user}', 'destroy');
    });

    Route::controller(CopyController::class)->group(function () {
        Route::get('users/{user}/copies', 'indexUserCopies');
        Route::post('users/{user}/copies', 'storeUserCopy');
    });

});

    //Registered

Route::group(['middleware' => 'auth:api'], function(){
    Route::apiResource('/copies', CopyController::class);
});

