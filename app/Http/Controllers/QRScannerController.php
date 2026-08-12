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
                ->route('attendance.index')
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

        $now = now();

        $startTime = today()->setTimeFromTimeString(
            $class->start_time
        );

        $endTime = today()->setTimeFromTimeString(
            $class->end_time
        );

        if ($now->lt($startTime)) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance has not started yet.'
            ], 422);
        }

        if ($now->gte($endTime)) {

            $session->update([
                'status' => 'closed',
                'ended_at' => now(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'The class attendance period has ended.'
            ], 422);
        }

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'session_id' => 'required|exists:attendance_sessions,id',
            'student_id' => 'required|string',
        ]);

        $class = SchoolClass::findOrFail(
            $request->class_id
        );

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
                'message' => 'Attendance session is not active.',
                'debug' => [ 'class_id' => $class->id, 'session_class_id' => $session->class_id, 'session_status' => $session->status, ],
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Find student
        |--------------------------------------------------------------------------
        */

        $qrValue = trim($request->student_id);

        $student = Student::where(
            'student_id',
            $qrValue
        )->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.',
                'debug' => [ 'qr_value' => $qrValue, ],
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Check if student belongs to class
        |--------------------------------------------------------------------------
        */

        if (
            !$class->section_id ||
            !$student->section_id ||
            $student->section_id != $class->section_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This student does not belong to this class section.',
                'debug' => [
                    'student_section_id' => $student->section_id,
                    'class_section_id' => $class->section_id,
                ],
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
                    'name' => $student->first_name .
                        ' ' .
                        $student->last_name,
                    'time_in' => $existingAttendance->time_in,
                    'status' => ucfirst(
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

        $status = now()->lte($startTime)
        ? 'present'
        : 'late';

        $attendance = Attendance::create([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'attendance_date' => $session->attendance_date,
            'time_in' => now()->format('H:i:s'),
            'status' => 'present',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance recorded successfully.',
            'student' => [
                'student_id' => $student->student_id,
                'name' => $student->first_name .
                    ' ' .
                    $student->last_name,
                'time_in' => $attendance->time_in,
                'status' => 'Present',
            ],
        ]);
    }
}