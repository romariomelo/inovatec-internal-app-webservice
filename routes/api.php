<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\TipoTefController;
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

        Route::get('/', [TipoTefController::class, 'index']);

        Route::get('/{id}', [TipoTefController::class, 'get']);

        Route::post('/', [TipoTefController::class, 'create']);

        Route::put('/{id}', [TipoTefController::class, 'update']);

        Route::delete('/{id}', [TipoTefController::class, 'delete']);
    }); //prefix = tefTypes


    Route::prefix('providers')->group(function () {

        Route::get('/', [FornecedorController::class, 'index']);

        Route::get('/{id}', [FornecedorController::class, 'get']);

        Route::post('/', [FornecedorController::class, 'create']);

        Route::put('/{id}', [FornecedorController::class, 'update']);

        Route::delete('/{id}', [FornecedorController::class, 'delete']);
    }); //prefix = providers
}); // middleware = api; prefix = v1
