@extends('layouts.app')

@section('title', 'Edit Teacher')

@section('page-title', 'Teachers')

@push('styles')
    @vite('resources/css/teacher.css')
@endpush

@section('content')

<div class="teacher-page-header">

    <div>

        <h1>Edit Teacher</h1>

        <p>
            Update teacher information
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
            ✏️
        </div>

        <div>

            <h2>
                Edit Teacher Information
            </h2>

            <p>
                Update the teacher's information below.
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
            action="{{ route('teachers.update', $teacher) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <div class="form-grid">


                <div class="form-group">

                    <label>
                        Teacher ID
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="teacher_id"
                        class="form-control"
                        value="{{ old('teacher_id', $teacher->teacher_id) }}"
                        required
                    >

                    @error('teacher_id')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        First Name
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="first_name"
                        class="form-control"
                        value="{{ old('first_name', $teacher->first_name) }}"
                        required
                    >

                    @error('first_name')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Last Name
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="last_name"
                        class="form-control"
                        value="{{ old('last_name', $teacher->last_name) }}"
                        required
                    >

                    @error('last_name')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $teacher->email) }}"
                    >

                    @error('email')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Department
                    </label>

                    <input
                        type="text"
                        name="department"
                        class="form-control"
                        value="{{ old('department', $teacher->department) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Position
                    </label>

                    <input
                        type="text"
                        name="position"
                        class="form-control"
                        value="{{ old('position', $teacher->position) }}"
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
                    ✓ Update Teacher
                </button>

            </div>

        </form>

    </div>

</div>

@endsection