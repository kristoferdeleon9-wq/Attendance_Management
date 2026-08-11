@extends('layouts.app')

@section('title', 'QR Scanner')

@section('page-title', 'Attendance Scanner')

@push('styles')
    @vite('resources/css/attendance-scanner.css')
@endpush

@section('content')

<div class="scanner-page">

    {{-- HEADER --}}

    <div class="scanner-header">

        <div>

            <span class="scanner-label">
                QR ATTENDANCE
            </span>

            <h1>
                {{ $class->class_name }}
            </h1>

            <p>
                {{ $class->subject }}
                •
                {{ $class->section?->name ?? 'No Section' }}
            </p>

        </div>


        <div class="scanner-header-actions">

            <div class="live-status">

                <span class="live-dot"></span>

                Attendance Open

            </div>

            <a
                href="{{ route(
                    'attendance.session',
                    $session
                ) }}"
                class="btn btn-secondary"
            >
                ← Back
            </a>

        </div>

    </div>


    {{-- SCANNER AREA --}}

    <div class="scanner-layout">


        {{-- QR SCANNER --}}

        <div class="scanner-card">

            <div class="scanner-card-header">

                <div>

                    <h2>
                        Scan Student QR
                    </h2>

                    <p>
                        Position the student's QR code inside the frame.
                    </p>

                </div>

                <span class="scanner-open">
                    OPEN
                </span>

            </div>


            <div class="scanner-container">

                <div id="reader"></div>

            </div>


            <div class="scanner-help">

                <span class="help-icon">
                    i
                </span>

                <p>
                    Make sure the QR code is clearly visible
                    and the camera has permission to operate.
                </p>

            </div>

        </div>


        {{-- RESULT --}}

        <div class="result-card">

            <div class="result-header">

                <div>

                    <h2>
                        Scan Result
                    </h2>

                    <p>
                        Latest attendance scan
                    </p>

                </div>

            </div>


            <div
                id="scan-result"
                class="scan-result empty"
            >

                <div class="result-icon">
                    ▣
                </div>

                <h3>
                    Waiting for scan
                </h3>

                <p>
                    Scan a student's QR code to record attendance.
                </p>

            </div>

        </div>

    </div>


    {{-- CLASS INFORMATION --}}

    <div class="scanner-info-grid">

        <div class="scanner-info">

            <span>
                Section
            </span>

            <strong>
                {{ $class->section?->name ?? '—' }}
            </strong>

        </div>


        <div class="scanner-info">

            <span>
                Instructor
            </span>

            <strong>

                @if($class->teacher)

                    {{ $class->teacher->first_name }}
                    {{ $class->teacher->last_name }}

                @else

                    —

                @endif

            </strong>

        </div>


        <div class="scanner-info">

            <span>
                Date
            </span>

            <strong>
                {{ $session->attendance_date->format('F d, Y') }}
            </strong>

        </div>


        <div class="scanner-info">

            <span>
                Started
            </span>

            <strong>
                {{ $session->started_at
                    ? $session->started_at->format('h:i A')
                    : '—'
                }}
            </strong>

        </div>

    </div>

</div>


<script src="https://unpkg.com/html5-qrcode"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const resultBox =
        document.getElementById('scan-result');

    let scanning = true;

    function showResult(
        type,
        title,
        message,
        student = null
    ) {

        resultBox.className =
            'scan-result ' + type;

        let html = '';

        if (type === 'success') {

            html += `
                <div class="result-icon success-icon">
                    ✓
                </div>
            `;

        } else if (type === 'duplicate') {

            html += `
                <div class="result-icon duplicate-icon">
                    !
                </div>
            `;

        } else {

            html += `
                <div class="result-icon error-icon">
                    !
                </div>
            `;

        }

        html += `
            <h3>${title}</h3>
            <p>${message}</p>
        `;

        if (student) {

            html += `
                <div class="student-result">

                    <strong>
                        ${student.name}
                    </strong>

                    <span>
                        Student ID:
                        ${student.student_id}
                    </span>

                    <span>
                        Time In:
                        ${student.time_in ?? '—'}
                    </span>

                    <span>
                        Status:
                        ${student.status}
                    </span>

                </div>
            `;

        }

        resultBox.innerHTML = html;
    }


    function onScanSuccess(decodedText) {

        if (!scanning) {
            return;
        }

        scanning = false;

        fetch("{{ route('attendance.scan') }}", {

            method: "POST",

            headers: {

                "Content-Type":
                    "application/json",

                "Accept":
                    "application/json",

                "X-CSRF-TOKEN":
                    "{{ csrf_token() }}"

            },

            body: JSON.stringify({

                class_id:
                    {{ $class->id }},

                session_id:
                    {{ $session->id }},

                student_id:
                    decodedText.trim()

            })

        })

        .then(response => response.json())

        .then(data => {

            if (data.success) {

                showResult(
                    'success',
                    'Attendance Recorded',
                    data.message,
                    data.student
                );

            } else if (data.duplicate) {

                showResult(
                    'duplicate',
                    'Already Recorded',
                    data.message,
                    data.student
                );

            } else {

                showResult(
                    'error',
                    'Scan Failed',
                    data.message
                );

            }

            setTimeout(() => {

                scanning = true;

                resultBox.className =
                    'scan-result empty';

                resultBox.innerHTML = `
                    <div class="result-icon">
                        ▣
                    </div>

                    <h3>
                        Waiting for scan
                    </h3>

                    <p>
                        Scan another student's QR code.
                    </p>
                `;

            }, 3000);

        })

        .catch(error => {

            console.error(error);

            showResult(
                'error',
                'Connection Error',
                'Unable to connect to the server.'
            );

            setTimeout(() => {
                scanning = true;
            }, 3000);

        });

    }


    function onScanFailure(error) {
        // Ignore normal scanner failures.
    }


    const scanner =
        new Html5QrcodeScanner(
            "reader",
            {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                },
                rememberLastUsedCamera: true
            },
            false
        );


    scanner.render(
        onScanSuccess,
        onScanFailure
    );

});

</script>

@endsection