@extends('layouts.app')

@section('title', 'View Class')

@section('page-title', 'Classes')

@push('styles')
    @vite('resources/css/class-show.css')
@endpush

@section('content')

<div class="class-page-header">

    <div>

        <h1>
            {{ $class->class_name }}
        </h1>

        <p>
            View class information and attendance details
        </p>

    </div>


    <div class="header-actions">

        <a
            href="{{ route('classes.index') }}"
            class="btn btn-secondary"
        >
            ← Back to Classes
        </a>

        <a
            href="{{ route('classes.edit', $class) }}"
            class="btn btn-primary"
        >
            ✏️ Edit Class
        </a>

    </div>

</div>


{{-- CLASS INFORMATION --}}

<div class="class-info-card">

    <div class="class-info-header">

        <div class="class-icon">
            📚
        </div>

        <div class="class-title">

            <h2>
                {{ $class->class_name }}
            </h2>

            <p>
                {{ $class->subject }}
            </p>

        </div>

    </div>


    <div class="class-info-body">

        <div class="info-grid">

            {{-- CLASS NAME --}}
            <div class="info-item">

                <span class="info-label">
                    Class Name
                </span>

                <strong class="info-value">
                    {{ $class->class_name ?? '—' }}
                </strong>

            </div>

            {{-- SUBJECT --}}

            <div class="info-item">

                <span class="info-label">
                    Subject
                </span>

                <strong class="info-value">
                    {{ $class->subject ?? '—' }}
                </strong>

            </div>


            {{-- SECTION --}}

            <div class="info-item">

                <span class="info-label">
                    Section
                </span>

                <strong class="info-value">
                    {{ $class->section?->name ?? '—' }}
                </strong>

            </div>

            {{-- INSTRUCTOR --}}

            <div class="info-item">

                <span class="info-label">
                    Instructor
                </span>

                <strong class="info-value">
                    @if($class->teacher)
                        {{ $class->teacher->first_name }}
                        {{ $class->teacher->last_name }}
                    @else
                        —
                    @endif
                </strong>

            </div>


            {{-- ROOM --}}

            <div class="info-item">

                <span class="info-label">
                    Room
                </span>

                <strong class="info-value">
                    {{ $class->room ?? '—' }}
                </strong>

            </div>


            {{-- SCHEDULE --}}

            <div class="info-item info-full">

                <span class="info-label">
                    Schedule
                </span>

                <strong class="info-value">
                    {{ $class->schedule ?? '—' }}
                </strong>

            </div>


            {{-- DESCRIPTION --}}

            <div class="info-item info-full">

                <span class="info-label">
                    Description
                </span>

                <p class="description">

                    {{ $class->description ?? 'No description provided.' }}

                </p>

            </div>

        </div>

    </div>

</div>


{{-- QUICK ACTIONS --}}

<div class="class-actions-card">

    <div class="section-header">

        <div>

            <h2>
                Class Actions
            </h2>

            <p>
                Manage this class and its attendance.
            </p>

        </div>

    </div>


    <div class="class-actions">

    {{-- OPEN ATTENDANCE --}}
    <form
        action="{{ route('attendance.session.start') }}"
        method="POST"
        class="class-action-form"
    >
        @csrf

        <input
            type="hidden"
            name="class_id"
            value="{{ $class->id }}"
        >

        <button
            type="submit"
            class="class-action"
        >
            <div class="action-icon blue">
                ▶
            </div>

            <div class="action-content">
                <strong>
                    Open Attendance
                </strong>

                <span>
                    Open a new attendance session for this class
                </span>
            </div>

            <span class="action-arrow">
                →
            </span>
        </button>
    </form>


    {{-- VIEW ATTENDANCE --}}
    <a
        href="{{ route('attendance.index', ['class_id' => $class->id]) }}"
        class="class-action"
    >
        <div class="action-icon green">
            ✓
        </div>

        <div class="action-content">
            <strong>
                View Attendance
            </strong>

            <span>
                View attendance records for this class
            </span>
        </div>

        <span class="action-arrow">
            →
        </span>
    </a>


    {{-- EDIT CLASS --}}
    <a
        href="{{ route('classes.edit', $class) }}"
        class="class-action"
    >
        <div class="action-icon purple">
            ✏️
        </div>

        <div class="action-content">
            <strong>
                Edit Class
            </strong>

            <span>
                Update class information
            </span>
        </div>

        <span class="action-arrow">
            →
        </span>
    </a>

</div>

</div>


{{-- DANGER ZONE --}}

<div class="danger-card">

    <div>

        <h2>
            Delete Class
        </h2>

        <p>
            Permanently remove this class from the system.
        </p>

    </div>


    <form
        action="{{ route('classes.destroy', $class) }}"
        method="POST"
    >

        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="btn btn-danger"
            onclick="return confirm('Are you sure you want to delete this class?')"
        >
            🗑 Delete Class
        </button>

    </form>

</div>

@endsection