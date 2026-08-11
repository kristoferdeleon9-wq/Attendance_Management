@extends('layouts.app')

@section('title', $section->name)

@section('page-title', $section->name)

@push('styles')
    @vite('resources/css/sections.css')
@endpush

@section('content')

<div class="section-header">

    <div class="header-left">

        <h1>
            {{ $section->name }}
        </h1>

        <p>
            {{ $section->year_level }}
            • {{ $section->school_year }}
            • Adviser: {{ $section->adviser }}
        </p>

    </div>

    <div class="page-actions">

        <a href="{{ route('sections.index') }}"
           class="btn-secondary">

            ← Sections

        </a>

        <a href="{{ route('students.create', ['section_id' => $section->id]) }}"
           class="btn btn-primary">

            + Add Student

        </a>

    </div>

</div>


<div class="student-card">

    <div class="table-header">

        <div class="table-title">

            <h2>
                Students
            </h2>

            <p>
                {{ $section->students->count() }}
                students in this section
            </p>

        </div>

    </div>


    @if($section->students->count())

        <div class="table-container">

            <table class="student-table">

                <thead>

                    <tr>

                        <th>Student ID</th>

                        <th>Student</th>

                        <th>Email</th>

                        <th>Course</th>

                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($section->students as $student)

                        <tr>

                            <td>
                                {{ $student->student_id }}
                            </td>

                            <td>

                                <div class="student-name">

                                    <div class="avatar">

                                        {{ strtoupper(
                                            substr(
                                                $student->first_name,
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>

                                    <div class="name-info">

                                        <strong>

                                            {{ $student->first_name }}
                                            {{ $student->last_name }}

                                        </strong>

                                        <span>
                                            {{ $section->name }}
                                        </span>

                                    </div>

                                </div>

                            </td>

                            <td>
                                {{ $student->email ?? '—' }}
                            </td>

                            <td>
                                {{ $student->course }}
                            </td>

                            <td>

                                <div class="actions">

                                    <a href="{{ route('students.edit', $student) }}"
                                       class="btn btn-small btn-edit">

                                        Edit

                                    </a>

                                    <form
                                        action="{{ route('students.destroy', $student) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-small btn-delete"
                                            onclick="return confirm('Delete this student?')"
                                        >

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                👥
            </div>

            <h3>
                No Students
            </h3>

            <p>
                Add a student to {{ $section->name }}.
            </p>

            <a
                href="{{ route('students.create', ['section_id' => $section->id]) }}"
                class="btn btn-primary"
            >

                + Add Student

            </a>

        </div>

    @endif

</div>

@endsection