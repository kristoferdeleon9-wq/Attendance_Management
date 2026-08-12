<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC COUNTS
        |--------------------------------------------------------------------------
        */

        $totalStudents = Student::count();

        $totalTeachers = Teacher::count();

        $totalClasses = SchoolClass::count();


        /*
        |--------------------------------------------------------------------------
        | TODAY
        |--------------------------------------------------------------------------
        */

        $today = Carbon::today();


        /*
        |--------------------------------------------------------------------------
        | TODAY'S ATTENDANCE
        |--------------------------------------------------------------------------
        */

        $todayAttendances = Attendance::whereDate(
            'attendance_date',
            $today
        );


        /*
        |--------------------------------------------------------------------------
        | STATUS COUNTS
        |--------------------------------------------------------------------------
        */

        $todayPresent = (clone $todayAttendances)
            ->where('status', 'present')
            ->count();

        $todayLate = (clone $todayAttendances)
            ->where('status', 'late')
            ->count();

        $todayExcused = (clone $todayAttendances)
            ->where('status', 'excused')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | STUDENTS WHO ATTENDED TODAY
        |--------------------------------------------------------------------------
        */

        $studentsAttendedToday = (clone $todayAttendances)
            ->distinct('student_id')
            ->count('student_id');


        /*
        |--------------------------------------------------------------------------
        | ABSENT
        |--------------------------------------------------------------------------
        |
        | A student is considered absent if they have no attendance
        | record for today.
        |
        */

        $todayAbsent = max(
            0,
            $totalStudents - $studentsAttendedToday
        );


        /*
        |--------------------------------------------------------------------------
        | ATTENDANCE PERCENTAGE
        |--------------------------------------------------------------------------
        */

        $attendancePercentage = $totalStudents > 0
            ? round(
                ($studentsAttendedToday / $totalStudents) * 100
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | ACTIVE ATTENDANCE SESSIONS
        |--------------------------------------------------------------------------
        */

        $activeSessions = AttendanceSession::with([
            'schoolClass.section'
        ])
        ->whereDate('attendance_date', $today)
        ->where('status', 'open')
        ->latest('started_at')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | RECENT ATTENDANCE
        |--------------------------------------------------------------------------
        */

        $recentAttendances = Attendance::with([
            'student',
            'schoolClass.section'
        ])
        ->latest('id')
        ->take(8)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClasses',

            'todayPresent',
            'todayLate',
            'todayAbsent',
            'todayExcused',

            'studentsAttendedToday',
            'attendancePercentage',

            'activeSessions',
            'recentAttendances'
        ));
    }
}