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
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| PUBLIC HOME PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('main');
})->name('home');

Route::get('/student-access', function () {
    return view('student-access');
})->name('student.access');


/*
|--------------------------------------------------------------------------
| LOGIN / LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/student/register', [StudentController::class, 'studentRegister'])
    ->name('student.register');

Route::post('/student/register', [StudentController::class, 'studentStore'])
    ->name('student.register.store');


/*
|--------------------------------------------------------------------------
| LOGGED-IN USERS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        // Students
        Route::resource('students', StudentController::class);

        Route::post('/students/import', [StudentController::class, 'import'])
            ->name('students.import');

        Route::post('/students/{student}/assign-section', [StudentController::class, 'assignSection'])
            ->name('students.assign-section');

        // Sections
        Route::resource('sections', SectionController::class);

        // Classes
        Route::resource('classes', SchoolClassController::class);

        // Teachers
        Route::resource('teachers', TeacherController::class);

    });


    /*
    |--------------------------------------------------------------------------
    | ADMIN + TEACHER
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,teacher')->group(function () {

        // Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])
            ->name('attendance.index');

        Route::post('/attendance', [AttendanceController::class, 'store'])
            ->name('attendance.store');

        Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])
            ->name('attendance.update');


        // Attendance Session
        Route::post('/attendance/session/start', [AttendanceSessionController::class, 'start'])
            ->name('attendance.session.start');

        Route::get('/attendance/session/{session}', [AttendanceSessionController::class, 'show'])
            ->name('attendance.session');

        Route::post('/attendance/session/{session}/end', [AttendanceSessionController::class, 'end'])
            ->name('attendance.session.end');


        // QR Scanner
        Route::get('/attendance/scanner/{class}', [QrScannerController::class, 'index'])
            ->name('attendance.scanner');

        Route::post('/attendance/scanner/scan', [QrScannerController::class, 'scan'])
            ->name('attendance.scan');


        // Reports
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

    });

    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');


    /*
    |--------------------------------------------------------------------------
    | STUDENT QR
    |--------------------------------------------------------------------------
    */

    Route::get('/students/{student}/qr', [StudentQrController::class, 'show'])
        ->name('students.qr');

});