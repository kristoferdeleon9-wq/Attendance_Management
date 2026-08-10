@extends('layouts.app')

@section('title', 'Edit Class')

@section('page-title', 'Classes')

@push('styles')
    @vite('resources/css/class-create.css')
@endpush

@section('content')

<div class="class-page-header">

    <div>
        <h1>Edit Class</h1>

        <p>
            Update class information
        </p>
    </div>

</div>


<div class="class-form-card">

    <div class="form-header">

        <div class="form-icon">
            ✏️
        </div>

        <div>
            <h2>Edit Class Information</h2>

            <p>
                Update the details below.
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

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('classes.update', $class) }}"
            method="POST">

            @csrf
            @method('PUT')

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
                        value="{{ old('class_name', $class->class_name) }}"
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
                        value="{{ old('subject', $class->subject) }}"
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

                    <label for="section">
                        Section
                    </label>

                    <input
                        type="text"
                        id="section"
                        name="section"
                        class="form-control"
                        value="{{ old('section', $class->section) }}"
                        placeholder="e.g. BSIT 4A"
                    >

                </div>


                <div class="form-group">

                    <label for="schedule">
                        Schedule
                    </label>

                    <input
                        type="text"
                        id="schedule"
                        name="schedule"
                        class="form-control"
                        value="{{ old('schedule', $class->schedule) }}"
                        placeholder="e.g. Monday & Wednesday, 8:00 AM - 10:00 AM"
                    >

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
                        value="{{ old('room', $class->room) }}"
                        placeholder="e.g. Room 204"
                    >

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
                    ✓ Update Class
                </button>

            </div>

        </form>
    </div>
</div>

@endsection