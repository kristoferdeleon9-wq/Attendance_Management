<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AttendanceSession;

class AttendanceController extends Controller
{
    /**
     * Display the attendance page.
     */
    public function index(Request $request)
    {
        // Get all classes with their sections
        $classes = SchoolClass::with('section')
            ->orderBy('class_name')
            ->get();

        // Selected class
        $classId = $request->class_id;

        // Selected date
        $date = $request->date
            ?? Carbon::today()->toDateString();

        $schoolClass = null;
        $attendanceSession = null;
        $students = collect();
        $attendances = collect();

        if ($classId) {

            // Get selected class
            $schoolClass = SchoolClass::with('section')
                ->findOrFail($classId);

            /*
            |--------------------------------------------------------------------------
            | Get students from the CLASS SECTION
            |--------------------------------------------------------------------------
            */

            if ($schoolClass->section_id) {

                $students = \App\Models\Student::where(
                    'section_id',
                    $schoolClass->section_id
                )
                    ->orderBy('last_name')
                    ->orderBy('first_name')
                    ->get();
            }

            /*
            |--------------------------------------------------------------------------
            | Get attendance for this class and date
            |--------------------------------------------------------------------------
            */

            $attendances = Attendance::where(
                'class_id',
                $schoolClass->id
            )
                ->whereDate(
                    'attendance_date',
                    $date
                )
                ->get()
                ->keyBy('student_id');
        }

        if ($schoolClass) {
            $attendanceSession = AttendanceSession::where('class_id', $schoolClass->id)
                ->whereDate('attendance_date', $date)
                ->latest('id')
                ->first();
        }

        return view('attendance.index', compact(
            'classes',
            'schoolClass',
            'students',
            'attendances',
            'date',
            'attendanceSession'
        ));
    }


    /**
     * Store attendance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late,excused',
        ]);

        $class = SchoolClass::findOrFail($request->class_id);

        // Get IDs of students actually enrolled in this class
        $studentIds = $class->students()
            ->pluck('students.id')
            ->toArray();

        foreach ($request->attendance as $studentId => $status) {

            // Make sure the student belongs to this class
            if (!in_array($studentId, $studentIds)) {
                continue;
            }

            // Time-in only applies to Present or Late
            $timeIn = null;

            if (in_array($status, ['present', 'late'])) {
                $timeIn = now()->format('H:i:s');
            }

            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id' => $request->class_id,
                    'attendance_date' => $request->attendance_date,
                ],
                [
                    'status' => $status,
                    'time_in' => $timeIn,
                ]
            );
        }

        return redirect()
            ->route('attendance.index', [
                'class_id' => $request->class_id,
                'date' => $request->attendance_date,
            ])
            ->with('success', 'Attendance saved successfully.');
    }


    /**
     * Update one attendance record.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late,excused',
        ]);

        $timeIn = null;

        if (in_array($request->status, ['present', 'late'])) {
            $timeIn = $attendance->time_in ?? now()->format('H:i:s');
        }

        $attendance->update([
            'status' => $request->status,
            'time_in' => $timeIn,
        ]);

        return back()->with(
            'success',
            'Attendance updated successfully.'
        );
    }
}