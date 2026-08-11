@extends('layouts.app')

@section('title', 'Sections')

@section('page-title', 'Sections')

@push('styles')
@vite('resources/css/sections.css')
@endpush

@section('content')

<div class="section-header">

    <div class="header-left">

        <h1>
            Section Management
        </h1>

        <p>
            Manage sections and their assigned students
        </p>

    </div>

    <div class="page-actions">

        <a href="{{ route('sections.create') }}"
           class="btn btn-primary">

            + Create Section

        </a>

    </div>

</div>


@if(session('success'))

    <div class="alert-success">

        <span>✓</span>

        {{ session('success') }}

    </div>

@endif


<div class="sections-grid">

    @forelse($sections as $section)

        <div class="section-card">

            <div class="section-card-header">

                <div>

                    <h2>
                        {{ $section->name }}
                    </h2>

                    <span class="year-badge">
                        {{ $section->year_level }}
                    </span>

                </div>

                <div class="section-actions">

                    <a href="{{ route('sections.edit', $section) }}"
                       class="btn btn-small btn-edit">

                        Edit

                    </a>

                    <form action="{{ route('sections.destroy', $section) }}"
                          method="POST"
                          onsubmit="return confirm('Delete this section?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-small btn-delete">

                            Delete

                        </button>

                    </form>

                </div>

            </div>


            <div class="section-info">

                <div>
                    <strong>Adviser</strong>
                    <span>{{ $section->adviser }}</span>
                </div>

                <div>
                    <strong>School Year</strong>
                    <span>{{ $section->school_year }}</span>
                </div>

                <div>
                    <strong>Students</strong>
                    <span>{{ $section->students->count() }}</span>
                </div>

            </div>


            <div class="students-preview">

                <h3>
                    Students
                </h3>

                @forelse($section->students->take(5) as $student)

                    <div class="student-row">

                        <div class="avatar">

                            {{ strtoupper(
                                substr($student->first_name, 0, 1)
                            ) }}

                        </div>

                        <div class="student-info">

                            <strong>

                                {{ $student->first_name }}
                                {{ $student->last_name }}

                            </strong>

                            <span>
                                {{ $student->student_id }}
                            </span>

                        </div>

                    </div>

                @empty

                    <div class="no-students">

                        No students assigned yet.

                    </div>

                @endforelse


                @if($section->students->count() > 5)

                    <p class="more-students">

                        + {{ $section->students->count() - 5 }}
                        more students

                    </p>

                @endif

            </div>


            <div class="section-card-footer">

                <a href="{{ route('sections.show', $section) }}"
                   class="btn btn-primary">

                    View Students

                </a>

            </div>

        </div>

    @empty

        <div class="empty-state">

            <div class="empty-icon">
                📚
            </div>

            <h3>
                No Sections Found
            </h3>

            <p>
                Create your first section to start adding students.
            </p>

            <a href="{{ route('sections.create') }}"
               class="btn btn-primary">

                + Create Section

            </a>

        </div>

    @endforelse

</div>

@endsection