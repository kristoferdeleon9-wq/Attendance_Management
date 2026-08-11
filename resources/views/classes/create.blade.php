@extends('layouts.app')

@section('title', 'Create Class')

@section('page-title', 'Classes')

@push('styles')
    @vite('resources/css/class-create.css')
@endpush

@section('content')

<div class="class-page-header">

    <div>

        <h1>Create Class</h1>

        <p>
            Add a new class to your attendance system.
        </p>

    </div>

    <a
        href="{{ route('classes.index') }}"
        class="back-button"
    >
        ← Back to Classes
    </a>

</div>


<div class="class-form-card">

    <div class="form-header">

        <div class="form-icon">
            📚
        </div>

        <div>

            <h2>
                Class Information
            </h2>

            <p>
                Enter the information for this class.
            </p>

        </div>

    </div>


    <div class="form-body">

        @if($errors->any())

            <div class="error-box">

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

        @endif


        <form
            action="{{ route('classes.store') }}"
            method="POST"
        >

            @csrf


            <div class="form-grid">

                <div class="form-group">

                    <label for="class_name">
                        Class Name
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="class_name"
                        name="class_name"
                        class="form-control"
                        value="{{ old('class_name') }}"
                        placeholder="e.g. Web Development"
                        required
                    >

                    @error('class_name')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <div class="form-group">

                    <label for="subject">
                        Subject
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        class="form-control"
                        value="{{ old('subject') }}"
                        placeholder="e.g. IT 401"
                        required
                    >

                    @error('subject')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <div class="form-group">

                    <label for="section_id">
                        Section
                        <span class="required">*</span>
                    </label>

                    <select
                        id="section_id"
                        name="section_id"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Select Section
                        </option>

                        @foreach($sections as $section)

                            <option
                                value="{{ $section->id }}"
                                {{ old('section_id') == $section->id ? 'selected' : '' }}
                            >
                                {{ $section->name }}
                                — {{ $section->year_level }}
                            </option>

                        @endforeach

                    </select>

                    @error('section_id')
                        <span class="field-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="teacher_id">
                        Instructor
                        <span class="required">*</span>
                    </label>

                    <select
                        id="teacher_id"
                        name="teacher_id"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Select Instructor
                        </option>

                        @foreach($teachers as $teacher)

                            <option
                                value="{{ $teacher->id }}"
                                {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}
                            >
                                {{ $teacher->first_name }}
                                {{ $teacher->last_name }}
                            </option>

                        @endforeach

                    </select>

                    @error('teacher_id')
                        <span class="field-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <div class="form-group">

                    <label for="room">
                        Room
                    </label>

                    <input
                        type="text"
                        id="room"
                        name="room"
                        class="form-control"
                        value="{{ old('room') }}"
                        placeholder="e.g. Room 204"
                    >

                </div>


                <div class="form-group form-full">

                    <label for="schedule">
                        Schedule
                    </label>

                    <input
                        type="text"
                        id="schedule"
                        name="schedule"
                        class="form-control"
                        value="{{ old('schedule') }}"
                        placeholder="e.g. Monday & Wednesday, 8:00 AM - 10:00 AM"
                    >

                </div>


                <div class="form-group form-full">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control textarea"
                        placeholder="Optional class description..."
                    >{{ old('description') }}</textarea>

                </div>

            </div>


            <div class="form-footer">

                <a
                    href="{{ route('classes.index') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    ✓ Create Class
                </button>

            </div>

        </form>

    </div>

</div>

@endsection