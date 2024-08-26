<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieRentController;

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'index']);
Route::post('/user/create', [UserController::class, 'create']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->patch('/user/update/', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/user/delete/', [UserController::class, 'delete']);
Route::middleware('auth:sanctum')->get('/movies', [MovieController::class, 'index']);
Route::middleware('auth:sanctum')->post('/movie/create', [MovieController::class, 'create']);
Route::middleware('auth:sanctum')->patch('/movie/update/{id}', [MovieController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/movie/delete/{id}', [MovieController::class, 'delete']);
Route::middleware('auth:sanctum')->get('/rent/recent', [MovieRentController::class, 'recent']);
Route::middleware('auth:sanctum')->get('/rent/my-rents/', [MovieRentController::class, 'byUser']);
Route::middleware('auth:sanctum')->post('/rent', [MovieRentController::class, 'rent']);
Route::middleware('auth:sanctum')->patch('/rent/return/{id}', [MovieRentController::class, 'return']);