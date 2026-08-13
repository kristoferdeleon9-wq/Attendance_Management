@extends('layouts.app')

@section('title', 'Student Access')

@section('page-title', 'Student Access')

@push('styles')
    @vite('resources/css/student-access.css')
@endpush

@section('content')

<div class="student-access-page">

    <div class="student-access-card">

        <div class="student-access-icon">
            👨‍🎓
        </div>

        <h1>
            Student Access
        </h1>

        <p>
            Enter your Student ID to access your attendance information.
        </p>

        <form method="GET" action="{{ route('students.qr', ':student') }}"
              onsubmit="this.action = this.action.replace(':student', document.getElementById('student_id').value);">

            <label for="student_id">
                Student ID
            </label>

            <input
                type="text"
                id="student_id"
                name="student_id"
                placeholder="Enter your Student ID"
                required
            >

            <button type="submit">
                Continue
            </button>

        </form>

        <a href="{{ url('/') }}" class="back-link">
            ← Back to Home
        </a>

    </div>

</div>

@endsection