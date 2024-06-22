<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Middleware\AuthMiddleware;
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


Route::middleware([AuthMiddleware::class])->prefix('pedidos')->group(function () {
    Route::post('terminar/{pedido_id}', [PedidoController::class, 'terminarPedido']);
});

Route::middleware([AuthMiddleware::class])->prefix('domotica')->group(function () {
    Route::post('/{switch}', [PedidoController::class, 'switch']);
});
