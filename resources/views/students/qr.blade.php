@extends('layouts.app')

@section('title', 'Student QR Code')

@section('page-title', 'Student QR Code')

@push('styles')
    @vite('resources/css/student-qr.css')
@endpush

@section('content')

<div class="qr-page">

    <div class="qr-header">

        <div>
            <h1>Student QR Code</h1>

            <p>
                Use this QR code for attendance scanning.
            </p>
        </div>

        <a
            href="{{ route('students.index') }}"
            class="btn btn-secondary"
        >
            ← Back to Students
        </a>

    </div>


    <div class="qr-card">

        <div class="student-details">

            <div class="student-avatar">
                {{ strtoupper(substr($student->first_name, 0, 1)) }}
            </div>

            <div>

                <h2>
                    {{ $student->first_name }}
                    {{ $student->last_name }}
                </h2>

                <p>
                    Student ID:
                    <strong>{{ $student->student_id }}</strong>
                </p>

                @if($student->course)
                    <p>
                        {{ $student->course }}
                        @if($student->year_level)
                            • {{ $student->year_level }}
                        @endif
                    </p>
                @endif

            </div>

        </div>


        <div class="qr-container">

            {!! $qrCode !!}

        </div>


        <div class="qr-information">

            <h3>
                Attendance QR Code
            </h3>

            <p>
                This QR code belongs to
                <strong>
                    {{ $student->first_name }}
                    {{ $student->last_name }}
                </strong>.
            </p>

            <p class="student-number">
                {{ $student->student_id }}
            </p>

        </div>


        <div class="qr-actions">

            <button
                type="button"
                class="btn btn-primary"
                onclick="window.print()"
            >
                🖨 Print QR Code
            </button>

            <a
                href="{{ route('students.index') }}"
                class="btn btn-secondary"
            >
                Done
            </a>

        </div>

    </div>

</div>

@endsection