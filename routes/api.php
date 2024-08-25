<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieRentController;

Route::get('/user', [UserController::class, 'index']);
Route::post('/user/create', [UserController::class, 'create']);
Route::patch('/user/update/{id}', [UserController::class, 'update']);
Route::delete('/user/delete/{id}', [UserController::class, 'delete']);
Route::get('/movies', [MovieController::class, 'index']);
Route::post('/movie/create', [MovieController::class, 'create']);
Route::patch('/movie/update/{id}', [MovieController::class, 'update']);
Route::delete('/movie/delete/{id}', [MovieController::class, 'delete']);
Route::get('/rent/recent', [MovieRentController::class, 'recent']);
Route::get('/rent/byUser/{userId}', [MovieRentController::class, 'byUser']);
Route::post('/rent', [MovieRentController::class, 'rent']);
Route::patch('/rent/return/{id}', [MovieRentController::class, 'return']);