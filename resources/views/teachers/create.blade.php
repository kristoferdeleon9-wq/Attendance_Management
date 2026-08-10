@extends('layouts.app')

@section('title', 'Add Teacher')

@section('page-title', 'Teachers')

@push('styles')
    @vite('resources/css/teacher.css')
@endpush

@section('content')

<div class="teacher-page-header">

    <div>

        <h1>Add Teacher</h1>

        <p>
            Register a new teacher in the system
        </p>

    </div>

</div>


<a
    href="{{ route('teachers.index') }}"
    class="back-button"
>
    ← Back to Teachers
</a>


<div class="teacher-form-card">

    <div class="form-header">

        <div class="form-icon">
            👨‍🏫
        </div>

        <div>

            <h2>
                Teacher Information
            </h2>

            <p>
                Enter the teacher's information below.
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
            action="{{ route('teachers.store') }}"
            method="POST"
        >

            @csrf


            <div class="form-grid">


                <div class="form-group">

                    <label for="teacher_id">
                        Teacher ID
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="teacher_id"
                        name="teacher_id"
                        class="form-control"
                        value="{{ old('teacher_id') }}"
                        placeholder="e.g. T-0001"
                        required
                    >

                    @error('teacher_id')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


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

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="teacher@example.com"
                    >

                    @error('email')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <div class="form-group">

                    <label for="department">
                        Department
                    </label>

                    <input
                        type="text"
                        id="department"
                        name="department"
                        class="form-control"
                        value="{{ old('department') }}"
                        placeholder="e.g. Information Technology"
                    >

                </div>


                <div class="form-group">

                    <label for="position">
                        Position
                    </label>

                    <input
                        type="text"
                        id="position"
                        name="position"
                        class="form-control"
                        value="{{ old('position') }}"
                        placeholder="e.g. Instructor"
                    >

                </div>

            </div>


            <div class="form-footer">

                <a
                    href="{{ route('teachers.index') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    ✓ Save Teacher
                </button>

            </div>

        </form>

    </div>

</div>

@endsection