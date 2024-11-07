<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DynamoController;


Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{taskId}', [TaskController::class, 'show']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{taskId}', [TaskController::class, 'update']);
Route::delete('/tasks/{taskId}', [TaskController::class, 'destroy']);
