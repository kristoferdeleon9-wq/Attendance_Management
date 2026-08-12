<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AttendanceSession;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::with('section')
            ->orderBy('class_name')
            ->get();

        $classId = $request->class_id;

        $dateFrom = $request->date_from
            ?? Carbon::today()->format('Y-m-d');

        $dateTo = $request->date_to
            ?? Carbon::today()->format('Y-m-d');

        $attendances = collect();

        if ($classId) {

            $attendances = Attendance::with('student')
                ->where('class_id', $classId)
                ->whereBetween('attendance_date', [
                    $dateFrom,
                    $dateTo
                ])
                ->orderBy('attendance_date', 'desc')
                ->orderBy('time_in')
                ->get();
        }

        $total = $attendances->count();

        $present = $attendances
            ->where('status', 'present')
            ->count();

        $late = $attendances
            ->where('status', 'late')
            ->count();

        $absent = $attendances
            ->where('status', 'absent')
            ->count();

        $excused = $attendances
            ->where('status', 'excused')
            ->count();

        $attendancePercentage = $total > 0
            ? round((($present + $late) / $total) * 100, 2)
            : 0;

        $schoolClass = $classId
            ? SchoolClass::with('section')->find($classId)
            : null;

        $attendanceSession = $schoolClass
            ? AttendanceSession::where('class_id', $schoolClass->id)
                ->whereDate('attendance_date', $date)
                ->latest('id')
                ->first()
            : null;

        return view('reports.index', compact(
            'classes',
            'schoolClass',
            'attendances',
            'dateFrom',
            'dateTo',
            'attendanceSession',
            'total',
            'present',
            'late',
            'absent',
            'excused',
            'attendancePercentage'
        ));
    }
}