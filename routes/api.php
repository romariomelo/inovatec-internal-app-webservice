<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\TefTypeController;
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

Route::middleware('api')->prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {

        Route::post('login', [AuthController::class, 'login']);

        Route::post('logout', [AuthController::class, 'logout']);

        Route::post('refresh', [AuthController::class, 'refresh']);

        Route::post('me', [AuthController::class, 'me']);
    }); //prefix = auth

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
}); // middleware = api; prefix = v1
