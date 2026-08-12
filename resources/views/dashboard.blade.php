@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

@section('content')

<div class="dashboard-page">

    {{-- ==========================================
         WELCOME
    =========================================== --}}

    <div class="dashboard-header">

        <div>

            <h1>
                Welcome back, Administrator! 👋
            </h1>

            <p>
                Here's what's happening with your attendance system today.
            </p>

        </div>

    </div>


    {{-- ==========================================
         STATISTICS
    =========================================== --}}

    <div class="dashboard-stats">


        {{-- STUDENTS --}}

        <div class="dashboard-card">

            <div class="dashboard-card-top">

                <div class="dashboard-icon blue">
                    👥
                </div>

                <span class="dashboard-label">
                    Students
                </span>

            </div>

            <h2>
                {{ $totalStudents }}
            </h2>

            <p class="dashboard-description">
                Registered students
            </p>

            <a
                href="{{ route('students.index') }}"
                class="dashboard-link"
            >
                View students →
            </a>

        </div>


        {{-- TEACHERS --}}

        <div class="dashboard-card">

            <div class="dashboard-card-top">

                <div class="dashboard-icon purple">
                    👨‍🏫
                </div>

                <span class="dashboard-label">
                    Teachers
                </span>

            </div>

            <h2>
                {{ $totalTeachers }}
            </h2>

            <p class="dashboard-description">
                Registered teachers
            </p>

            <a
                href="{{ route('teachers.index') }}"
                class="dashboard-link"
            >
                Manage teachers →
            </a>

        </div>


        {{-- CLASSES --}}

        <div class="dashboard-card">

            <div class="dashboard-card-top">

                <div class="dashboard-icon orange">
                    📚
                </div>

                <span class="dashboard-label">
                    Classes
                </span>

            </div>

            <h2>
                {{ $totalClasses }}
            </h2>

            <p class="dashboard-description">
                Active classes
            </p>

            <a
                href="{{ route('classes.index') }}"
                class="dashboard-link"
            >
                View classes →
            </a>

        </div>


        {{-- ATTENDANCE --}}

        <div class="dashboard-card">

            <div class="dashboard-card-top">

                <div class="dashboard-icon green">
                    ✓
                </div>

                <span class="dashboard-label">
                    Attendance
                </span>

            </div>

            <h2>
                {{ $attendancePercentage }}%
            </h2>

            <p class="dashboard-description">
                Today's attendance
            </p>

            <a
                href="{{ route('attendance.index') }}"
                class="dashboard-link"
            >
                View attendance →
            </a>

        </div>

    </div>


    {{-- ==========================================
         TODAY + ACTIVE SESSIONS
    =========================================== --}}

    <div class="dashboard-grid">


        {{-- TODAY'S ATTENDANCE --}}

        <div class="dashboard-panel">

            <div class="panel-header">

                <div>

                    <h2>
                        Today's Attendance
                    </h2>

                    <p>
                        Attendance summary for today
                    </p>

                </div>

            </div>


            <div class="attendance-summary">


                {{-- PRESENT --}}

                <div class="summary-item">

                    <div class="summary-left">

                        <span class="summary-dot green"></span>

                        <span>
                            Present
                        </span>

                    </div>

                    <strong>
                        {{ $todayPresent }}
                    </strong>

                </div>


                {{-- LATE --}}

                <div class="summary-item">

                    <div class="summary-left">

                        <span class="summary-dot yellow"></span>

                        <span>
                            Late
                        </span>

                    </div>

                    <strong>
                        {{ $todayLate }}
                    </strong>

                </div>


                {{-- ABSENT --}}

                <div class="summary-item">

                    <div class="summary-left">

                        <span class="summary-dot red"></span>

                        <span>
                            Absent
                        </span>

                    </div>

                    <strong>
                        {{ $todayAbsent }}
                    </strong>

                </div>


                {{-- EXCUSED --}}

                <div class="summary-item">

                    <div class="summary-left">

                        <span class="summary-dot purple"></span>

                        <span>
                            Excused
                        </span>

                    </div>

                    <strong>
                        {{ $todayExcused }}
                    </strong>

                </div>

            </div>

        </div>



        {{-- ACTIVE ATTENDANCE --}}

        <div class="dashboard-panel">

            <div class="panel-header">

                <div>

                    <h2>
                        Active Attendance
                    </h2>

                    <p>
                        Currently open attendance sessions
                    </p>

                </div>

            </div>


            @forelse($activeSessions as $session)

                <div class="active-session">

                    <div class="active-session-icon">
                        📚
                    </div>

                    <div class="active-session-content">

                        <strong>

                            {{ $session->schoolClass->class_name ?? 'Class' }}

                        </strong>

                        <span>

                            @if($session->schoolClass?->section)
                                Section {{ $session->schoolClass->section->name }}
                            @else
                                No section
                            @endif

                        </span>

                        <small>

                            Started at
                            {{ $session->started_at
                                ? $session->started_at->format('h:i A')
                                : '—'
                            }}

                        </small>

                    </div>

                    <div class="session-status">
                        <span></span>
                        OPEN
                    </div>

                </div>

            @empty

                <div class="dashboard-empty-small">

                    <span>
                        📋
                    </span>

                    <p>
                        No attendance session is currently open.
                    </p>

                </div>

            @endforelse

        </div>

    </div>



    {{-- ==========================================
         QUICK ACTIONS + SYSTEM OVERVIEW
    =========================================== --}}

    <div class="dashboard-grid">


        {{-- QUICK ACTIONS --}}

        <div class="dashboard-panel">

            <div class="panel-header">

                <div>

                    <h2>
                        Quick Actions
                    </h2>

                    <p>
                        Frequently used features
                    </p>

                </div>

            </div>


            <div class="quick-actions">


                {{-- ADD STUDENT --}}

                <a
                    href="{{ route('students.create') }}"
                    class="quick-action"
                >

                    <div class="quick-icon blue">
                        +
                    </div>

                    <div>

                        <strong>
                            Add Student
                        </strong>

                        <span>
                            Register a new student
                        </span>

                    </div>

                </a>


                {{-- CREATE CLASS --}}

                <a
                    href="{{ route('classes.create') }}"
                    class="quick-action"
                >

                    <div class="quick-icon purple">
                        📚
                    </div>

                    <div>

                        <strong>
                            Create Class
                        </strong>

                        <span>
                            Create a new class
                        </span>

                    </div>

                </a>


                {{-- ATTENDANCE --}}

                <a
                    href="{{ route('attendance.index') }}"
                    class="quick-action"
                >

                    <div class="quick-icon green">
                        ✓
                    </div>

                    <div>

                        <strong>
                            Attendance
                        </strong>

                        <span>
                            View today's attendance
                        </span>

                    </div>

                </a>


                {{-- REPORT --}}

                <a
                    href="{{ route('reports.index') }}"
                    class="quick-action"
                >

                    <div class="quick-icon orange">
                        📊
                    </div>

                    <div>

                        <strong>
                            Attendance Report
                        </strong>

                        <span>
                            View attendance records
                        </span>

                    </div>

                </a>

            </div>

        </div>



        {{-- SYSTEM OVERVIEW --}}

        <div class="dashboard-panel">

            <div class="panel-header">

                <div>

                    <h2>
                        System Overview
                    </h2>

                    <p>
                        Current system information
                    </p>

                </div>

            </div>


            <div class="system-list">


                <div class="system-item">

                    <div class="system-item-left">

                        <span class="system-dot green"></span>

                        <span>
                            System Status
                        </span>

                    </div>

                    <strong class="status-online">
                        Online
                    </strong>

                </div>


                <div class="system-item">

                    <div class="system-item-left">

                        <span class="system-dot blue"></span>

                        <span>
                            Database
                        </span>

                    </div>

                    <strong class="status-online">
                        Connected
                    </strong>

                </div>


                <div class="system-item">

                    <div class="system-item-left">

                        <span class="system-dot purple"></span>

                        <span>
                            QR Scanner
                        </span>

                    </div>

                    <strong>
                        Ready
                    </strong>

                </div>


                <div class="system-item">

                    <div class="system-item-left">

                        <span class="system-dot orange"></span>

                        <span>
                            Last Update
                        </span>

                    </div>

                    <strong>
                        {{ now()->format('h:i A') }}
                    </strong>

                </div>

            </div>

        </div>

    </div>



    {{-- ==========================================
         RECENT ATTENDANCE
    =========================================== --}}

    <div class="dashboard-panel recent-panel">

        <div class="panel-header">

            <div>

                <h2>
                    Recent Attendance
                </h2>

                <p>
                    Latest attendance activity
                </p>

            </div>

            <a
                href="{{ route('attendance.index') }}"
                class="view-all"
            >
                View all →
            </a>

        </div>


        @if($recentAttendances->count())

            <div class="recent-attendance-list">

                @foreach($recentAttendances as $attendance)

                    <div class="recent-attendance-item">


                        <div class="recent-avatar">

                            {{ strtoupper(
                                substr(
                                    $attendance->student->first_name ?? 'S',
                                    0,
                                    1
                                )
                            ) }}

                        </div>


                        <div class="recent-student">

                            <strong>

                                {{ $attendance->student->first_name ?? '' }}

                                {{ $attendance->student->last_name ?? '' }}

                            </strong>

                            <span>

                                {{ $attendance->schoolClass->class_name ?? 'Class' }}

                            </span>

                        </div>


                        <div class="recent-time">

                            {{ $attendance->time_in
                                ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A')
                                : '—'
                            }}

                        </div>


                        <span
                            class="status-badge status-{{ $attendance->status }}"
                        >

                            {{ ucfirst($attendance->status) }}

                        </span>

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty-dashboard">

                <div class="empty-dashboard-icon">
                    📋
                </div>

                <h3>
                    No attendance records yet
                </h3>

                <p>
                    Attendance records will appear here once students start checking in.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection