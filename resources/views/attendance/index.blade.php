@extends('layouts.app')

@section('title', 'Attendance Management')

@push('styles')
@vite('resources/css/attendance.css')
@endpush

@section('content')

<div class="attendance-page">

{{-- PAGE HEADER --}}
<div class="attendance-header">
    <div>
        <h1>Attendance Management</h1>
        <p>Manage and monitor student attendance.</p>
    </div>
</div>


{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="alert-success">
        <span>✓</span>
        {{ session('success') }}
    </div>
@endif


{{-- CLASS & DATE FILTER --}}
<div class="attendance-filter-card">

    <form method="GET" action="{{ route('attendance.index') }}">

        <div class="filter-group">

            <div class="form-group">
                <label for="class_id">Class</label>

                <select
                    name="class_id"
                    id="class_id"
                    onchange="this.form.submit()"
                >
                    <option value="">Select Class</option>

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


            <div class="form-group">
                <label for="date">Attendance Date</label>

                <input
                    type="date"
                    name="date"
                    id="date"
                    value="{{ $date }}"
                    onchange="this.form.submit()"
                >
            </div>

        </div>

    </form>

</div>


{{-- SHOW ATTENDANCE ONLY AFTER CLASS IS SELECTED --}}
@if($schoolClass)

    {{-- CLASS INFORMATION --}}
    <div class="selected-class">

        <div class="class-icon">
            📚
        </div>

        <div>
            <h2>
                {{ $schoolClass->class_name }}
            </h2>

            <p>
                {{ $schoolClass->subject }}
                @if($schoolClass->section?->name)
                    • Section {{ $schoolClass->section?->name }}
                @endif
            </p>
        </div>

    </div>

    @if($attendanceSession)
    <div class="attendance-session-info">

        <div class="session-info-item">
            <span class="session-label">Attendance Opened</span>

            <strong>
                {{ $attendanceSession->started_at
                    ? $attendanceSession->started_at->format('h:i A')
                    : '—'
                }}
            </strong>
        </div>

        <div class="session-info-item">
            <span class="session-label">Attendance Closed</span>

            <strong>
                {{ $attendanceSession->ended_at
                    ? $attendanceSession->ended_at->format('h:i A')
                    : 'Still Open'
                }}
            </strong>
        </div>

        <div class="session-info-item">
            <span class="session-label">Session Status</span>

            <strong>
                {{ ucfirst($attendanceSession->status) }}
            </strong>
        </div>

    </div>
@endif


    {{-- ATTENDANCE SUMMARY --}}
    <div class="attendance-summary">

        <div class="summary-card present">
            <div class="summary-icon">
                ✓
            </div>

            <div>
                <span>Present</span>
                <strong id="presentCount">0</strong>
            </div>
        </div>


        <div class="summary-card absent">
            <div class="summary-icon">
                ✕
            </div>

            <div>
                <span>Absent</span>
                <strong id="absentCount">0</strong>
            </div>
        </div>


        <div class="summary-card late">
            <div class="summary-icon">
                ⏱
            </div>

            <div>
                <span>Late</span>
                <strong id="lateCount">0</strong>
            </div>
        </div>


        <div class="summary-card excused">
            <div class="summary-icon">
                !
            </div>

            <div>
                <span>Excused</span>
                <strong id="excusedCount">0</strong>
            </div>
        </div>

    </div>


    {{-- ATTENDANCE TABLE CARD --}}
    <div class="attendance-card">

        <div class="attendance-card-header">

            <div>
                <h2>Student Attendance</h2>

                <p>
                    {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                </p>
            </div>


            {{-- FILTER BUTTONS --}}
            <div class="attendance-tabs">

                <button
                    type="button"
                    class="attendance-tab active"
                    data-filter="all"
                >
                    All
                </button>

                <button
                    type="button"
                    class="attendance-tab"
                    data-filter="present"
                >
                    Present
                </button>

                <button
                    type="button"
                    class="attendance-tab"
                    data-filter="absent"
                >
                    Absent
                </button>

                <button
                    type="button"
                    class="attendance-tab"
                    data-filter="late"
                >
                    Late
                </button>

                <button
                    type="button"
                    class="attendance-tab"
                    data-filter="excused"
                >
                    Excused
                </button>

            </div>

        </div>


        {{-- SEARCH --}}
        <div class="attendance-search">

            <span>⌕</span>

            <input
                type="text"
                id="studentSearch"
                placeholder="Search student..."
            >

        </div>


        {{-- ATTENDANCE FORM --}}
        <form
            method="POST"
            action="{{ route('attendance.store') }}"
        >

            @csrf

            <input
                type="hidden"
                name="class_id"
                value="{{ $schoolClass->id }}"
            >

            <input
                type="hidden"
                name="attendance_date"
                value="{{ $date }}"
            >


            {{-- TABLE --}}
            <div class="table-wrapper">

                <table class="attendance-table">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Time In</th>
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody id="attendanceTableBody">

                    @forelse($students as $index => $student)

                        @php

                            $attendance = $attendances->get($student->id);

                            $status = $attendance
                                ? $attendance->status
                                : 'absent';

                        @endphp

                        <tr
                            class="student-row"
                            data-status="{{ $status }}"
                        >

                            <td>
                                {{ $index + 1 }}
                            </td>


                            <td>
                                <span class="student-id">
                                    {{ $student->student_id }}
                                </span>
                            </td>


                            <td>

                                <div class="student-info">

                                    <div class="student-avatar">
                                        {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <strong>
                                            {{ $student->first_name }}
                                            {{ $student->last_name }}
                                        </strong>

                                        <small>
                                            {{ $student->course ?? 'No course' }}
                                            @if($student->year_level)
                                                • Year {{ $student->year_level }}
                                            @endif
                                        </small>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span class="time-in">
                                    {{ $attendance && $attendance->time_in
                                        ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A')
                                        : '—'
                                    }}
                                </span>

                            </td>


                            <td>

                                <select
                                    name="attendance[{{ $student->id }}]"
                                    class="status-select status-{{ $status }}"
                                    data-student="{{ $student->id }}"
                                >

                                    <option
                                        value="present"
                                        {{ $status === 'present' ? 'selected' : '' }}
                                    >
                                        Present
                                    </option>

                                    <option
                                        value="absent"
                                        {{ $status === 'absent' ? 'selected' : '' }}
                                    >
                                        Absent
                                    </option>

                                    <option
                                        value="late"
                                        {{ $status === 'late' ? 'selected' : '' }}
                                    >
                                        Late
                                    </option>

                                    <option
                                        value="excused"
                                        {{ $status === 'excused' ? 'selected' : '' }}
                                    >
                                        Excused
                                    </option>

                                </select>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="empty-state"
                            >
                                <div>
                                    <span>👨‍🎓</span>
                                    <h3>No students found</h3>
                                    <p>
                                        No students are enrolled in this class.
                                    </p>
                                </div>
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- SAVE BUTTON --}}
            @if($students->count() > 0)

                <div class="attendance-footer">

                    <div class="footer-info">
                        <span>
                            {{ $students->count() }}
                        </span>

                        students
                    </div>

                    <button
                        type="submit"
                        class="btn-save"
                    >
                        <span>✓</span>
                        Save Attendance
                    </button>

                </div>

            @endif

        </form>

    </div>

@else

    {{-- NO CLASS SELECTED --}}
    <div class="attendance-empty">

        <div class="empty-icon">
            📋
        </div>

        <h2>Select a Class</h2>

        <p>
            Select a class above to view and manage student attendance.
        </p>

    </div>

@endif

</div>

{{-- =========================
JAVASCRIPT
========================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const rows = document.querySelectorAll('.student-row');

    const tabs = document.querySelectorAll('.attendance-tab');

    const searchInput = document.getElementById('studentSearch');

    const presentCount = document.getElementById('presentCount');
    const absentCount = document.getElementById('absentCount');
    const lateCount = document.getElementById('lateCount');
    const excusedCount = document.getElementById('excusedCount');

    let currentFilter = 'all';


    /* =========================
       UPDATE SUMMARY
    ========================= */

    function updateSummary() {

        let present = 0;
        let absent = 0;
        let late = 0;
        let excused = 0;

        rows.forEach(row => {

            const select = row.querySelector('.status-select');

            if (!select) {
                return;
            }

            switch(select.value) {

                case 'present':
                    present++;
                    break;

                case 'absent':
                    absent++;
                    break;

                case 'late':
                    late++;
                    break;

                case 'excused':
                    excused++;
                    break;

            }

        });

        if (presentCount) {
            presentCount.textContent = present;
        }

        if (absentCount) {
            absentCount.textContent = absent;
        }

        if (lateCount) {
            lateCount.textContent = late;
        }

        if (excusedCount) {
            excusedCount.textContent = excused;
        }

    }


    /* =========================
       UPDATE SELECT COLOR
    ========================= */

    function updateSelect(select) {

        select.classList.remove(
            'status-present',
            'status-absent',
            'status-late',
            'status-excused'
        );

        select.classList.add(
            'status-' + select.value
        );

    }


    /* =========================
       FILTER STUDENTS
    ========================= */

    function filterStudents() {

        const search = searchInput
            ? searchInput.value.toLowerCase().trim()
            : '';

        rows.forEach(row => {

            const statusSelect =
                row.querySelector('.status-select');

            const status =
                statusSelect
                    ? statusSelect.value
                    : row.dataset.status;

            const text =
                row.textContent.toLowerCase();

            const matchesFilter =
                currentFilter === 'all' ||
                status === currentFilter;

            const matchesSearch =
                text.includes(search);

            row.style.display =
                matchesFilter && matchesSearch
                    ? ''
                    : 'none';

        });

    }


    /* =========================
       STATUS CHANGES
    ========================= */

    document
        .querySelectorAll('.status-select')
        .forEach(select => {

            updateSelect(select);

            select.addEventListener('change', function () {

                updateSelect(this);

                const row =
                    this.closest('.student-row');

                if (row) {
                    row.dataset.status = this.value;
                }

                updateSummary();

                filterStudents();

            });

        });


    /* =========================
       TAB FILTER
    ========================= */

    tabs.forEach(tab => {

        tab.addEventListener('click', function () {

            tabs.forEach(item => {
                item.classList.remove('active');
            });

            this.classList.add('active');

            currentFilter =
                this.dataset.filter;

            filterStudents();

        });

    });


    /* =========================
       SEARCH
    ========================= */

    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterStudents
        );

    }


    /* =========================
       INITIALIZE
    ========================= */

    updateSummary();

    filterStudents();

});

</script>

@endsection
