<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SectionController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/', function () {
    return redirect()->route('students.index');
});

Route::post('/students/import', [StudentController::class, 'import'])
    ->name('students.import');

Route::resource('students', StudentController::class);

Route::resource('sections', SectionController::class);

Route::resource('classes', SchoolClassController::class);

Route::resource('teachers', TeacherController::class);

Route::get('/attendance', [AttendanceController::class, 'index'])
    ->name('attendance.index');

Route::post('/attendance', [AttendanceController::class, 'store'])
    ->name('attendance.store');

Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])
    ->name('attendance.update');

Route::post('/students/{student}/assign-section', [StudentController::class, 'assignSection'])
    ->name('students.assign-section');