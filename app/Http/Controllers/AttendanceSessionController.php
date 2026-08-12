<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\AttendanceSession;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceSessionController extends Controller
{
    /**
     * Start attendance session.
     */
    public function start(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
        ]);

        $class = SchoolClass::findOrFail($request->class_id);

        // Check if there is already an open session today
        $existingSession = AttendanceSession::where('class_id', $class->id)
            ->whereDate('attendance_date', today())
            ->where('status', 'open')
            ->first();

        if ($existingSession) {
            return redirect()
                ->route('attendance.session', $existingSession)
                ->with('error', 'Attendance is already open for this class.');
        }

        // Create attendance session
        $session = AttendanceSession::create([
            'class_id' => $class->id,
            'attendance_date' => today(),
            'started_at' => now(),
            'status' => 'open',
        ]);

        return redirect()
            ->route('attendance.session', $session)
            ->with('success', 'Attendance opened successfully.');
    }

    /**
     * Display active session.
     */
    public function show(AttendanceSession $session)
    {
        $session->load([
            'schoolClass',
            'schoolClass.teacher',
            'schoolClass.section',
        ]);

        return view(
            'attendance.session',
            compact('session')
        );
    }

    /**
     * End attendance session.
     */
    public function end(AttendanceSession $session)
    {
        if ($session->status === 'closed') {
            return redirect()
                ->route('attendance.index')
                ->with('info', 'This attendance session is already closed.');
        }

        $session->update([
            'status' => 'closed',
            'ended_at' => now(),
        ]);

        return redirect()
            ->route('attendance.index')
            ->with(
                'success',
                'Attendance session ended successfully.'
            );
    }
}