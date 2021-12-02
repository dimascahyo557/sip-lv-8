<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\TransactionApiController;
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

// Route::middleware('auth:passport')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::get('category', [CategoryApiController::class, 'index'])->middleware('auth:api');
Route::get('category/{category}', [CategoryApiController::class, 'show'])->middleware('auth:api');
Route::post('category', [CategoryApiController::class, 'store'])->middleware('auth:api');
Route::put('category/{category}', [CategoryApiController::class, 'update'])->middleware('auth:api');
Route::delete('category/{category}', [CategoryApiController::class, 'destroy'])->middleware('auth:api');

Route::get('product', [ProductApiController::class, 'index'])->middleware('auth:api');
Route::get('product/{id}', [ProductApiController::class, 'show'])->middleware('auth:api');
Route::post('product', [ProductApiController::class, 'store'])->middleware('auth:api');
Route::post('product/{id}/update', [ProductApiController::class, 'update'])->middleware('auth:api');
Route::delete('product/{id}', [ProductApiController::class, 'destroy'])->middleware('auth:api');

Route::get('transaction', [TransactionApiController::class, 'index'])->middleware('auth:api');
Route::post('transaction/import', [TransactionApiController::class, 'import'])->middleware('auth:api');
Route::get('transaction/download', [TransactionApiController::class, 'export'])->middleware('auth:api');