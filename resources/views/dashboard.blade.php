@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@push('styles')
@vite('resources/css/dashboard.css')
@endpush

@section('content')

{{-- ==========================================
WELCOME HEADER
========================================== --}}

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
========================================== --}}

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
        0%
    </h2>

    <p class="dashboard-description">
        Today's attendance
    </p>

    <a
        href="#"
        class="dashboard-link"
    >
        View attendance →
    </a>

</div>

</div>

{{-- ==========================================
SECOND SECTION
========================================== --}}

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


        {{-- QR SCANNER --}}

        <a
            href="#"
            class="quick-action"
        >

            <div class="quick-icon green">
                ▣
            </div>

            <div>

                <strong>
                    Open QR Scanner
                </strong>

                <span>
                    Scan student attendance
                </span>

            </div>

        </a>


        {{-- REPORT --}}

        <a
            href="#"
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

        {{-- SYSTEM STATUS --}}

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


        {{-- DATABASE --}}

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


        {{-- QR SCANNER --}}

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


        {{-- LAST UPDATE --}}

        <div class="system-item">

            <div class="system-item-left">

                <span class="system-dot orange"></span>

                <span>
                    Last Update
                </span>

            </div>

            <strong>
                Today
            </strong>

        </div>

    </div>

</div>

</div>

{{-- ==========================================
RECENT ATTENDANCE
========================================== --}}

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
        href="#"
        class="view-all"
    >
        View all →
    </a>

</div>


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

</div>

@endsection
