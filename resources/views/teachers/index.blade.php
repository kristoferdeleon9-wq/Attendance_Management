@extends('layouts.app')

@section('title', 'Teachers')

@section('page-title', 'Teachers')

@push('styles')
    @vite('resources/css/teacher.css')
@endpush

@section('content')

<div class="teacher-page-header">

    <div>
        <h1>Teacher Management</h1>

        <p>
            Manage and organize registered teachers
        </p>
    </div>

    <a
        href="{{ route('teachers.create') }}"
        class="btn btn-primary"
    >
        + Add Teacher
    </a>

</div>


@if(session('success'))

    <div class="alert-success">
        ✓ {{ session('success') }}
    </div>

@endif


<div class="teacher-card">

    <div class="table-header">

        <div>
            <h2>Registered Teachers</h2>

            <p>
                {{ $teachers->count() }} teacher records found
            </p>
        </div>

        <div class="search-box">

            <span>🔍</span>

            <input
                type="text"
                id="teacherSearch"
                placeholder="Search teachers..."
            >

        </div>

    </div>


    @if($teachers->count() > 0)

        <div class="table-container">

            <table id="teachersTable">

                <thead>

                    <tr>
                        <th>Teacher ID</th>
                        <th>Teacher</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($teachers as $teacher)

                        <tr>

                            <td>
                                <span class="teacher-id">
                                    {{ $teacher->teacher_id }}
                                </span>
                            </td>


                            <td>

                                <div class="teacher-name">

                                    <div class="avatar">
                                        {{ strtoupper(substr($teacher->first_name, 0, 1)) }}
                                    </div>

                                    <div class="name-info">

                                        <strong>
                                            {{ $teacher->first_name }}
                                            {{ $teacher->last_name }}
                                        </strong>

                                        <span>
                                            Teacher
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>
                                {{ $teacher->email ?? '—' }}
                            </td>


                            <td>

                                <span class="badge badge-blue">
                                    {{ $teacher->department ?? '—' }}
                                </span>

                            </td>


                            <td>

                                <span class="badge badge-purple">
                                    {{ $teacher->position ?? '—' }}
                                </span>

                            </td>


                            <td>

                                <div class="actions">

                                    <a
                                        href="{{ route('teachers.edit', $teacher) }}"
                                        class="btn btn-small btn-edit"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('teachers.destroy', $teacher) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-small btn-delete"
                                            onclick="return confirm('Delete this teacher?')"
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
                👨‍🏫
            </div>

            <h3>
                No Teachers Found
            </h3>

            <p>
                Start by adding your first teacher.
            </p>

            <a
                href="{{ route('teachers.create') }}"
                class="btn btn-primary"
            >
                + Add Teacher
            </a>

        </div>

    @endif

</div>

@endsection