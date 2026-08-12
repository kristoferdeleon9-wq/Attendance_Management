<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Student;
use Illuminate\Http\Request;

class QrScannerController extends Controller
{
    /**
     * Show QR scanner.
     */
    public function index(SchoolClass $class)
    {
        $class->load([
            'teacher',
            'section',
            'students',
        ]);

        $session = AttendanceSession::where(
            'class_id',
            $class->id
        )
        ->whereDate(
            'attendance_date',
            today()
        )
        ->where('status', 'open')
        ->latest()
        ->first();

        if (!$session) {
            return redirect()
                ->route('classes.show', $class)
                ->with(
                    'error',
                    'There is no active attendance session for this class.'
                );
        }

        return view(
            'attendance.scanner',
            compact(
                'class',
                'session'
            )
        );
    }


    /**
     * Process QR code.
     */
    public function scan(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate QR scan request
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'session_id' => 'required|exists:attendance_sessions,id',
            'student_id' => 'required|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Get class
        |--------------------------------------------------------------------------
        */

        $class = SchoolClass::findOrFail(
            $request->class_id
        );


        /*
        |--------------------------------------------------------------------------
        | Get attendance session
        |--------------------------------------------------------------------------
        */

        $session = AttendanceSession::findOrFail(
            $request->session_id
        );


        /*
        |--------------------------------------------------------------------------
        | Verify session
        |--------------------------------------------------------------------------
        */

        if (
            $session->class_id != $class->id ||
            $session->status !== 'open'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance session is not active.'
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Find student
        |--------------------------------------------------------------------------
        */

        $student = Student::where(
            'student_id',
            $request->student_id
        )->first();


        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.'
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | SECTION ENROLLMENT
        |--------------------------------------------------------------------------
        |
        | Student does NOT need to exist in class_student.
        |
        | The student must belong to the same section as the class.
        |
        */

        if (
            !$class->section_id ||
            $student->section_id != $class->section_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This student is not enrolled in this class section.',
                'debug' => [
                    'student_database_id' => $student->id,
                    'student_id' => $student->student_id,
                    'student_section_id' => $student->section_id,
                    'class_id' => $class->id,
                    'class_section_id' => $class->section_id,
                    'class_name' => $class->class_name,
                ]
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Check duplicate attendance
        |--------------------------------------------------------------------------
        */

        $existingAttendance = Attendance::where(
            'student_id',
            $student->id
        )
        ->where(
            'class_id',
            $class->id
        )
        ->whereDate(
            'attendance_date',
            $session->attendance_date
        )
        ->first();


        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'duplicate' => true,
                'message' => 'Attendance already recorded.',
                'student' => [
                    'student_id' => $student->student_id,

                    'name' =>
                        $student->first_name .
                        ' ' .
                        $student->last_name,

                    'time_in' =>
                        $existingAttendance->time_in,

                    'status' =>
                        ucfirst(
                            $existingAttendance->status
                        ),
                ],
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Record attendance
        |--------------------------------------------------------------------------
        */

        $attendance = Attendance::create([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'attendance_date' => $session->attendance_date,
            'time_in' => now()->format('H:i:s'),
            'status' => 'present',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Success response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' =>
                'Attendance recorded successfully.',

            'student' => [
                'student_id' =>
                    $student->student_id,

                'name' =>
                    $student->first_name .
                    ' ' .
                    $student->last_name,

                'time_in' =>
                    $attendance->time_in,

                'status' =>
                    'Present',
            ],
        ]);
    }
}