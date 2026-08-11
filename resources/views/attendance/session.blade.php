@extends('layouts.app')

@section('title', 'Attendance Session')

@section('page-title', 'Attendance')

@push('styles')
    @vite('resources/css/attendance-session.css')
@endpush

@section('content')

<div class="attendance-session-page">

    {{-- HEADER --}}

    <div class="session-header">

        <div>

            <div class="session-breadcrumb">
                Attendance / Session
            </div>

            <h1>
                {{ $session->schoolClass->class_name }}
            </h1>

            <p>
                {{ $session->schoolClass->subject }}
            </p>

        </div>

        <div class="session-header-actions">

            <a
                href="{{ route('attendance.index') }}"
                class="btn btn-secondary"
            >
                ← Attendance
            </a>

            @if($session->status === 'open')

                <a
                    href="{{ route(
                        'attendance.scanner',
                        $session->schoolClass
                    ) }}"
                    class="btn btn-primary"
                >
                    ▣ Open QR Scanner
                </a>

            @endif

        </div>

    </div>


    {{-- SUCCESS --}}

    @if(session('success'))

        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>

    @endif


    {{-- INFO --}}

    @if(session('info'))

        <div class="alert alert-info">
            ℹ {{ session('info') }}
        </div>

    @endif


    {{-- SESSION STATUS --}}

    <div class="session-status-card">

        <div class="status-icon">
            @if($session->status === 'open')
                ●
            @else
                ✓
            @endif
        </div>

        <div class="status-content">

            <span class="status-label">
                Attendance Session
            </span>

            <strong>
                @if($session->status === 'open')
                    OPEN
                @else
                    CLOSED
                @endif
            </strong>

            <p>
                {{ $session->attendance_date->format('F d, Y') }}
            </p>

        </div>

        <div class="session-time">

            <span>
                Started
            </span>

            <strong>
                {{ $session->started_at
                    ? $session->started_at->format('h:i A')
                    : '—'
                }}
            </strong>

            @if($session->ended_at)

                <small>
                    Ended
                    {{ $session->ended_at->format('h:i A') }}
                </small>

            @endif

        </div>

    </div>


    {{-- CLASS INFORMATION --}}

    <div class="information-grid">

        <div class="information-card">

            <span>
                Subject
            </span>

            <strong>
                {{ $session->schoolClass->subject }}
            </strong>

        </div>


        <div class="information-card">

            <span>
                Section
            </span>

            <strong>
                {{ $session->schoolClass->section?->name ?? '—' }}
            </strong>

        </div>


        <div class="information-card">

            <span>
                Instructor
            </span>

            <strong>

                @if($session->schoolClass->teacher)

                    {{ $session->schoolClass->teacher->first_name }}
                    {{ $session->schoolClass->teacher->last_name }}

                @else

                    —

                @endif

            </strong>

        </div>


        <div class="information-card">

            <span>
                Room
            </span>

            <strong>
                {{ $session->schoolClass->room ?? '—' }}
            </strong>

        </div>

    </div>


    {{-- ACTIONS --}}

    <div class="session-action-card">

        <div>

            <h2>
                Attendance Controls
            </h2>

            <p>
                Manage the attendance session for this class.
            </p>

        </div>


        <div class="session-controls">

            @if($session->status === 'open')

                <a
                    href="{{ route(
                        'attendance.scanner',
                        $session->schoolClass
                    ) }}"
                    class="control-button scanner-button"
                >

                    <span class="control-icon">
                        ▣
                    </span>

                    <span>

                        <strong>
                            Open QR Scanner
                        </strong>

                        <small>
                            Scan student QR codes
                        </small>

                    </span>

                </a>


                <form
                    action="{{ route(
                        'attendance.session.end',
                        $session
                    ) }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="control-button end-button"
                        onclick="return confirm('End this attendance session?')"
                    >

                        <span class="control-icon">
                            ■
                        </span>

                        <span>

                            <strong>
                                End Session
                            </strong>

                            <small>
                                Close attendance
                            </small>

                        </span>

                    </button>

                </form>

            @else

                <div class="closed-message">

                    <span>
                        ✓
                    </span>

                    <div>

                        <strong>
                            Attendance session closed
                        </strong>

                        <small>
                            No more QR scans can be recorded.
                        </small>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection