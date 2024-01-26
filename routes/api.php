<?php

use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['as' => 'api.'], function () {

    Route::apiResource('users', UserController::class)->only('store');

    Route::get('not-auth', function () {
        return response()->json(['message' => 'unauthorized'])->setStatusCode(401);
    })->name('not-auth');
    Route::apiResource('tokens', TokenController::class)->only('store');

    Route::apiResource('tasks', TaskController::class)
        ->middleware('auth:sanctum');
});


