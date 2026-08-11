@extends('layouts.app')

@section('title', 'Add Student')

@section('page-title', 'Students')

@push('styles')
    @vite('resources/css/student-create.css')
@endpush

@section('content')

<div class="student-page-header">

    <div>
        <h1>Add Student</h1>

        <p>
            Register a new student in the system
        </p>
    </div>

    <a
        href="{{ route('students.index') }}"
        class="back-button"
    >
        ← Back to Students
    </a>

</div>


<div class="student-form-card">

    <div class="form-header">

        <div class="form-icon">
            👤
        </div>

        <div>
            <h2>Student Information</h2>

            <p>
                Enter the student's information below.
            </p>
        </div>

    </div>


    <div class="form-body">

        @if($errors->any())

            <div class="error-box">

                <div class="error-icon">
                    !
                </div>

                <div>

                    <strong>
                        Please fix the following errors:
                    </strong>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        <form
            action="{{ route('students.store') }}"
            method="POST"
        >

            @csrf


            <div class="form-grid">

                {{-- STUDENT ID --}}

                <div class="form-group">

                    <label for="student_id">
                        Student ID
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="student_id"
                        name="student_id"
                        class="form-control"
                        value="{{ old('student_id') }}"
                        placeholder="e.g. 2024-0001"
                        required
                    >

                    @error('student_id')
                        <span class="field-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- FIRST NAME --}}

                <div class="form-group">

                    <label for="first_name">
                        First Name
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        class="form-control"
                        value="{{ old('first_name') }}"
                        placeholder="e.g. Juan"
                        required
                    >

                    @error('first_name')
                        <span class="field-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- LAST NAME --}}

                <div class="form-group">

                    <label for="last_name">
                        Last Name
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        class="form-control"
                        value="{{ old('last_name') }}"
                        placeholder="e.g. Dela Cruz"
                        required
                    >

                    @error('last_name')
                        <span class="field-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="section">
                        Section
                    </label>

                    <input
                        type="text"
                        id="section"
                        value="{{ $section->name }}"
                        readonly
                    >

                    <input
                        type="hidden"
                        name="section_id"
                        value="{{ $section->id }}"
                    >

                    <small class="form-help">
                        Student will be added to this section.
                    </small>

                </div>


                {{-- EMAIL --}}

                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="student@example.com"
                    >

                    @error('email')
                        <span class="field-error">
                            {{ $message }}
                        </span>
                    @enderror

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
                        class="form-control"
                        value="{{ old('course') }}"
                        placeholder="e.g. BSIT"
                    >

                </div>


                {{-- YEAR LEVEL --}}

                <div class="form-group">

                    <label for="year_level">
                        Year Level
                    </label>

                    <select
                        id="year_level"
                        name="year_level"
                        class="form-control"
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

            </div>


            <div class="form-footer">

                <a
                    href="{{ route('students.index') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    ✓ Save Student
                </button>

            </div>

        </form>

    </div>

</div>

@endsection