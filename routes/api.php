<?php

use App\Http\Controllers\Api\CourseController;
use Illuminate\Support\Facades\Route;

Route::apiResource('courses', CourseController::class);
Route::patch('courses/{id}/restore', [CourseController::class, 'restore']);
