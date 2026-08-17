@extends('layouts.public')

@section('title', 'Student Registration')

@push('styles')
    @vite('resources/css/student-register.css')
@endpush

@section('content')

<div class="student-register-page">

    <div class="student-register-card">

    @if(session('success'))
    <div class="alert alert-success">
        ✓ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        ⚠ {{ session('error') }}
    </div>
@endif

        {{-- HEADER --}}
        <div class="student-register-header">

            <div class="student-register-logo">
                A
            </div>

            <h1>Student Registration</h1>

            <p>
                Enter your information to register for attendance.
            </p>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('student.register.store') }}"
            method="POST"
            class="student-register-form"
        >

            @csrf


            {{-- ERRORS --}}
            @if ($errors->any())

                <div class="error-message">

                    <strong>Please fix the following errors:</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif


            {{-- STUDENT ID --}}
            <div class="form-group">

                <label for="student_id">
                    Student ID <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="student_id"
                    name="student_id"
                    value="{{ old('student_id') }}"
                    placeholder="e.g. 2024-0001"
                    required
                >

            </div>


            {{-- FIRST NAME + LAST NAME --}}
            <div class="form-row">

                <div class="form-group">

                    <label for="first_name">
                        First Name <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        placeholder="e.g. Juan"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="last_name">
                        Last Name <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name') }}"
                        placeholder="e.g. Dela Cruz"
                        required
                    >

                </div>

            </div>


            {{-- SECTION --}}
            <div class="form-group">

                <label for="section_id">
                    Section <span class="required">*</span>
                </label>

                <select
                    id="section_id"
                    name="section_id"
                    required
                >

                    <option value="">
                        Select section
                    </option>

                    @foreach($sections as $section)

                        <option
                            value="{{ $section->id }}"
                            {{ old('section_id') == $section->id ? 'selected' : '' }}
                        >
                            {{ $section->name }}
                        </option>

                    @endforeach

                </select>

                <small>
                    Select the section where the student belongs.
                </small>

            </div>


            {{-- EMAIL + COURSE --}}
            <div class="form-row">

                {{-- EMAIL --}}
                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="student@example.com"
                    >

                </div>


                {{-- COURSE --}}
                <div class="form-group">

                    <label for="course">
                        Course
                    </label>

                    <input
                        type="text"
                        id="course"
                        name="course"
                        value="{{ old('course') }}"
                        placeholder="e.g. BSIT"
                    >

                </div>

            </div>


            {{-- YEAR LEVEL --}}
            <div class="form-group year-level-group">

                <label for="year_level">
                    Year Level
                </label>

                <select
                    id="year_level"
                    name="year_level"
                >

                    <option value="">
                        Select year level
                    </option>

                    <option
                        value="1st Year"
                        {{ old('year_level') == '1st Year' ? 'selected' : '' }}
                    >
                        1st Year
                    </option>

                    <option
                        value="2nd Year"
                        {{ old('year_level') == '2nd Year' ? 'selected' : '' }}
                    >
                        2nd Year
                    </option>

                    <option
                        value="3rd Year"
                        {{ old('year_level') == '3rd Year' ? 'selected' : '' }}
                    >
                        3rd Year
                    </option>

                    <option
                        value="4th Year"
                        {{ old('year_level') == '4th Year' ? 'selected' : '' }}
                    >
                        4th Year
                    </option>

                </select>

            </div>


            {{-- BUTTON --}}
            <div class="form-actions">

                <a
                    href="{{ url('/') }}"
                    class="cancel-btn"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="register-btn"
                >
                    ✓ Register Student
                </button>

            </div>

        </form>

    </div>

</div>

@push('scripts')
<script>
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert');

        alerts.forEach(function (alert) {
            alert.style.opacity = '0';

            setTimeout(function () {
                alert.remove();
            }, 500);
        });
    }, 4000);
</script>
@endpush

@endsection