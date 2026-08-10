@extends('layouts.app')

@section('title', 'Classes')

@section('page-title', 'Classes')

@push('styles')
    @vite('resources/css/classes.css')
@endpush

@section('content')

<div class="class-page-header">

    <div>

        <h1>Class Management</h1>

        <p>
            Manage subjects, sections, schedules, and classes.
        </p>

    </div>

    <a
        href="{{ route('classes.create') }}"
        class="btn btn-primary"
    >
        + Create Class
    </a>

</div>


@if(session('success'))

    <div class="alert-success">

        <span class="alert-icon">✓</span>

        {{ session('success') }}

    </div>

@endif


<div class="class-summary">

    <div>

        <strong>
            {{ $classes->count() }}
        </strong>

        <span>
            Total Classes
        </span>

    </div>

</div>


@if($classes->count() > 0)

    <div class="class-grid">

        @foreach($classes as $class)

            <div class="class-card">

                <div class="class-card-top">

                    <div class="class-icon">
                        📚
                    </div>

                    <span class="section-badge">
                        {{ $class->section }}
                    </span>

                </div>


                <div class="class-info">

                    <h2>
                        {{ $class->class_name }}
                    </h2>

                    <p class="subject">
                        {{ $class->subject }}
                    </p>

                </div>


                <div class="class-details">

                    @if($class->schedule)

                        <div class="detail-item">

                            <span class="detail-icon">
                                🕐
                            </span>

                            <span>
                                {{ $class->schedule }}
                            </span>

                        </div>

                    @endif


                    @if($class->room)

                        <div class="detail-item">

                            <span class="detail-icon">
                                📍
                            </span>

                            <span>
                                {{ $class->room }}
                            </span>

                        </div>

                    @endif

                </div>


                <div class="class-card-footer">

                    <a
                        href="{{ route('classes.show', $class) }}"
                        class="class-link"
                    >
                        View Class →
                    </a>

                    <div class="class-actions">

                        <a
                            href="{{ route('classes.edit', $class) }}"
                            class="action-edit"
                        >
                            Edit
                        </a>


                        <form
                            action="{{ route('classes.destroy', $class) }}"
                            method="POST"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="action-delete"
                                onclick="return confirm('Delete this class?')"
                            >
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@else

    <div class="empty-class">

        <div class="empty-class-icon">
            📚
        </div>

        <h2>
            No Classes Yet
        </h2>

        <p>
            Create your first class to start managing attendance.
        </p>

        <a
            href="{{ route('classes.create') }}"
            class="btn btn-primary"
        >
            + Create Your First Class
        </a>

    </div>

@endif

@endsection