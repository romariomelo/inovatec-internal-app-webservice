<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\TefTypeController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1/auth')->group(function () {

    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::post('me', [AuthController::class, 'me']);
}); //prefix = auth

Route::middleware('auth:api')->prefix('v1')->group(function () {



    Route::prefix('clients')->group(function () {

        Route::get('/', [ClientController::class, 'index']);

        Route::get('/{id}', [ClientController::class, 'get']);

        Route::post('/', [ClientController::class, 'create']);

        Route::put('/{id}', [ClientController::class, 'update']);

        Route::delete('/{id}', [ClientController::class, 'delete']);
    }); //prefix = clients

    Route::prefix('tefTypes')->group(function () {

        Route::get('/', [TefTypeController::class, 'index']);

        Route::get('/{id}', [TefTypeController::class, 'get']);

        Route::post('/', [TefTypeController::class, 'create']);

        Route::put('/{id}', [TefTypeController::class, 'update']);

        Route::delete('/{id}', [TefTypeController::class, 'delete']);
    }); //prefix = tefTypes


    Route::prefix('providers')->group(function () {

        Route::get('tef', [ProviderController::class, 'tef']);

        Route::get('software', [ProviderController::class, 'software']);

        Route::get('/', [ProviderController::class, 'index']);

        Route::get('/{id}', [ProviderController::class, 'get']);

        Route::post('/', [ProviderController::class, 'create']);

        Route::put('/{id}', [ProviderController::class, 'update']);

        Route::delete('/{id}', [ProviderController::class, 'delete']);
    }); //prefix = providers

    Route::prefix('users')->group(function() {

        Route::get('/', [UserController::class, 'index']);

        Route::post('/', [UserController::class, 'create']);

        Route::put('/change-password', [UserController::class, 'change_passsword']);
        Route::put('/{id}', [UserController::class, 'update']);


        Route::delete('/{id}', [UserController::class, 'delete']);
    }

    ); // prefix = users
}); // middleware = api; prefix = v1
