<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\AttendanceSessionController;
use App\Http\Controllers\QrScannerController;
use App\Http\Controllers\StudentQrController;
use App\Http\Controllers\ReportController;

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

Route::get('/students/{student}/qr', [StudentQrController::class, 'show'])
    ->name('students.qr');

Route::get('/attendance', [AttendanceController::class, 'index'])
    ->name('attendance.index');

Route::post('/attendance', [AttendanceController::class, 'store'])
    ->name('attendance.store');

Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])
    ->name('attendance.update');

Route::post('/students/{student}/assign-section', [StudentController::class, 'assignSection'])
    ->name('students.assign-section');

Route::post('/attendance/session/start', [AttendanceSessionController::class, 'start'])
    ->name('attendance.session.start');

Route::get('/attendance/session/{session}', [AttendanceSessionController::class, 'show'])
    ->name('attendance.session');

Route::post('/attendance/session/{session}/end', [AttendanceSessionController::class, 'end'])
    ->name('attendance.session.end');

Route::get('/attendance/scanner/{class}', [QrScannerController::class, 'index'])
    ->name('attendance.scanner');

Route::post('/attendance/scanner/scan', [QrScannerController::class, 'scan'])
    ->name('attendance.scan');

Route::get('/reports', [ReportController::class, 'index'])
    ->name('reports.index');