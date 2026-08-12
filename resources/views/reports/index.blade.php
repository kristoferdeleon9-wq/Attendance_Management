@extends('layouts.app')

@section('title', 'Attendance Reports')

@section('page-title', 'Reports')

@push('styles')
    @vite('resources/css/reports.css')
@endpush

@section('content')

<div class="reports-page">

    {{-- HEADER --}}
    <div class="reports-header">

        <div>
            <h1>Attendance Reports</h1>

            <p>
                View and analyze student attendance records.
            </p>
        </div>

    </div>


    {{-- FILTER CARD --}}
    <div class="report-filter-card">

        <form
            method="GET"
            action="{{ route('reports.index') }}"
        >

            <div class="report-filter-grid">

                {{-- CLASS --}}
                <div class="form-group">

                    <label for="class_id">
                        Class
                    </label>

                    <select
                        name="class_id"
                        id="class_id"
                        class="form-control"
                    >

                        <option value="">
                            Select Class
                        </option>

                        @foreach($classes as $class)

                            <option
                                value="{{ $class->id }}"
                                {{ request('class_id') == $class->id ? 'selected' : '' }}
                            >

                                {{ $class->class_name }}

                                @if($class->section)
                                    - {{ $class->section->name }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- FROM --}}
                <div class="form-group">

                    <label for="date_from">
                        Date From
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        id="date_from"
                        class="form-control"
                        value="{{ $dateFrom }}"
                    >

                </div>


                {{-- TO --}}
                <div class="form-group">

                    <label for="date_to">
                        Date To
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        id="date_to"
                        class="form-control"
                        value="{{ $dateTo }}"
                    >

                </div>


                {{-- BUTTON --}}
                <div class="report-filter-button">

                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        🔍 Generate Report
                    </button>

                </div>

            </div>

        </form>

    </div>


    @if($schoolClass)

        {{-- CLASS INFORMATION --}}
        <div class="report-class-card">

            <div class="report-class-icon">
                📚
            </div>

            <div>

                <h2>
                    {{ $schoolClass->class_name }}
                </h2>

                <p>

                    {{ $schoolClass->subject }}

                    @if($schoolClass->section)
                        • Section {{ $schoolClass->section->name }}
                    @endif

                </p>

            </div>

        </div>

        @if($attendanceSession)

            <div class="session-summary">

                {{-- ATTENDANCE OPENED --}}
                <div class="session-info">

                    <span class="session-info-label">
                        ATTENDANCE OPENED
                    </span>

                    <strong>
                        {{ $attendanceSession->started_at
                            ? $attendanceSession->started_at->format('h:i A')
                            : '—'
                        }}
                    </strong>

                </div>


                {{-- ATTENDANCE CLOSED --}}
                <div class="session-info">

                    <span class="session-info-label">
                        ATTENDANCE CLOSED
                    </span>

                    <strong>
                        {{ $attendanceSession->ended_at
                            ? $attendanceSession->ended_at->format('h:i A')
                            : '—'
                        }}
                    </strong>

                </div>


                {{-- SESSION STATUS --}}
                <div class="session-info">

                    <span class="session-info-label">
                        SESSION STATUS
                    </span>

                    <strong
                        class="
                            {{ $attendanceSession->status === 'open'
                                ? 'status-open'
                                : 'status-closed'
                            }}
                        "
                    >
                        {{ ucfirst($attendanceSession->status) }}
                    </strong>

                </div>

            </div>

        @endif


        {{-- SUMMARY --}}
        <div class="report-summary">

            {{-- TOTAL --}}
            <div class="report-summary-card">

                <div class="summary-icon blue">
                    👨‍🎓
                </div>

                <div>

                    <span>Total Records</span>

                    <strong>
                        {{ $total }}
                    </strong>

                </div>

            </div>


            {{-- PRESENT --}}
            <div class="report-summary-card">

                <div class="summary-icon green">
                    ✓
                </div>

                <div>

                    <span>Present</span>

                    <strong>
                        {{ $present }}
                    </strong>

                </div>

            </div>


            {{-- LATE --}}
            <div class="report-summary-card">

                <div class="summary-icon yellow">
                    ⏱
                </div>

                <div>

                    <span>Late</span>

                    <strong>
                        {{ $late }}
                    </strong>

                </div>

            </div>


            {{-- ABSENT --}}
            <div class="report-summary-card">

                <div class="summary-icon red">
                    ✕
                </div>

                <div>

                    <span>Absent</span>

                    <strong>
                        {{ $absent }}
                    </strong>

                </div>

            </div>


            {{-- EXCUSED --}}
            <div class="report-summary-card">

                <div class="summary-icon purple">
                    !
                </div>

                <div>

                    <span>Excused</span>

                    <strong>
                        {{ $excused }}
                    </strong>

                </div>

            </div>


            {{-- PERCENTAGE --}}
            <div class="report-summary-card">

                <div class="summary-icon teal">
                    %
                </div>

                <div>

                    <span>Attendance Rate</span>

                    <strong>
                        {{ $attendancePercentage }}%
                    </strong>

                </div>

            </div>

        </div>


        {{-- ATTENDANCE TABLE --}}
        <div class="report-table-card">

            <div class="report-table-header">

                <div>

                    <h2>
                        Attendance Records
                    </h2>

                    <p>

                        {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }}

                        -

                        {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}

                    </p>

                </div>

                <input
                    type="text"
                    id="reportSearch"
                    class="report-search"
                    placeholder="Search student..."
                >

            </div>


            <div class="table-wrapper">

                <table class="report-table">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Student ID</th>

                            <th>Student Name</th>

                            <th>Date</th>

                            <th>Time In</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody id="reportTableBody">

                    @forelse($attendances as $index => $attendance)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>

                                <span class="student-id">
                                    {{ $attendance->student->student_id ?? '—' }}
                                </span>

                            </td>

                            <td>

                                <strong>

                                    {{ $attendance->student->first_name ?? '' }}

                                    {{ $attendance->student->last_name ?? '' }}

                                </strong>

                            </td>

                            <td>

                                {{ $attendance->attendance_date
                                    ? $attendance->attendance_date->format('M d, Y')
                                    : '—'
                                }}

                            </td>

                            <td>

                                {{ $attendance->time_in
                                    ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A')
                                    : '—'
                                }}

                            </td>

                            <td>

                                <span class="status-badge status-{{ $attendance->status }}">

                                    {{ ucfirst($attendance->status) }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="empty-state"
                            >

                                <div>

                                    <span>📋</span>

                                    <h3>
                                        No attendance records
                                    </h3>

                                    <p>
                                        There are no attendance records for the selected class and date range.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    @else

        {{-- EMPTY --}}
        <div class="reports-empty">

            <div class="empty-icon">
                📊
            </div>

            <h2>
                Generate a Report
            </h2>

            <p>
                Select a class and date range above to view attendance records.
            </p>

        </div>

    @endif

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const search = document.getElementById('reportSearch');

    if (!search) {
        return;
    }

    search.addEventListener('input', function () {

        const value = this.value.toLowerCase();

        document
            .querySelectorAll('#reportTableBody tr')
            .forEach(row => {

                row.style.display =
                    row.textContent
                        .toLowerCase()
                        .includes(value)
                        ? ''
                        : 'none';

            });

    });

});

</script>

@endsection