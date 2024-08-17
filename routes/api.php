<?php

use App\Http\Controllers\DependencyFilesController;
use App\Http\Controllers\UserController;
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

Route::middleware('api')->post('login',[UserController::class,'login']);
Route::middleware('api')->post('register',[UserController::class,'register']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('upload',[DependencyFilesController::class,'upload']);
    Route::get('files',[DependencyFilesController::class,'files']);
});
