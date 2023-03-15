<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

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
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::prefix('products')->group(function () {
        Route::middleware(['role'])->group(function () {
            Route::post('/create', [ProductController::class, 'create']);
            Route::post('/update', [ProductController::class, 'update']);
            Route::delete('/delete/{id}', [ProductController::class, 'delete']);
        });
        Route::get('/list', [ProductController::class, 'getList']);
        Route::get('/detail', [ProductController::class, 'getDetail']);
    });

    Route::prefix('transaction')->group(function () {
        Route::post('/create', [TransactionController::class, 'create'])->middleware(['isadmin']);
        Route::get('/list', [TransactionController::class, 'getList']);
        Route::get('/detail', [TransactionController::class, 'getDetail']);
    });




});
