<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\TeacherController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/', function () {
    return redirect()->route('students.index');
});

Route::resource('students', StudentController::class);

Route::resource('classes', SchoolClassController::class);

Route::resource('teachers', TeacherController::class);