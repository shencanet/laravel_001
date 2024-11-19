<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;
use App\Models\Student;
use Iluminate\Support\Facades\Validator;


Route::get('/students', [studentController::class, 'index']);


Route::get('/students/{id}', [studentController::class, 'show']);

Route::put('/students/{id}', [studentController::class, 'update']);

Route::post('/students', [studentController::class, 'store']);


Route::patch('/students/{id}', [studentController::class, 'update_partial']);

Route::delete('/students/{id}', [studentController::class, 'Destroy']);

