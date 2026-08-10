@extends('layouts.app')

@section('title', 'Students')

@section('page-title', 'Students')

@push('styles')
@vite('resources/css/students.css')
@endpush

@section('content')

{{-- ==========================================
PAGE HEADER
========================================== --}}

<div class="student-header">

<div class="header-left">

    <h1>
        Student Management
    </h1>

    <p>
        Manage and organize registered students
    </p>

</div>

<div class="page-actions">

    <a href="{{ route('students.create') }}" class="btn btn-primary">
        + Add Student
    </a>

    <button type="button"
            class="btn-secondary"
            onclick="openImportModal()">
        Import Students
    </button>

</div>

</div>

{{-- ==========================================
SUCCESS MESSAGE
========================================== --}}

@if(session('success'))

<div class="alert-success">

    <span>✓</span>

    {{ session('success') }}

</div>

@endif

{{-- ==========================================
STUDENT TABLE CARD
========================================== --}}

<div class="student-card">

{{-- TABLE HEADER --}}

<div class="table-header">

    <div class="table-title">

        <h2>
            Registered Students
        </h2>

        <p>
            {{ $students->count() }}
            student records found
        </p>

    </div>


    {{-- SEARCH --}}

    <div class="search-box">

        <span class="search-icon">
            🔍
        </span>

        <input
            type="text"
            id="studentSearch"
            placeholder="Search students..."
            autocomplete="off"
        >

    </div>

</div>


{{-- ==========================================
     STUDENTS EXIST
========================================== --}}

@if($students->count() > 0)

    <div class="table-container">

        <table
            id="studentsTable"
            class="student-table"
        >

            <thead>

                <tr>

                    <th>
                        Student ID
                    </th>

                    <th>
                        Student
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Course
                    </th>

                    <th>
                        Year
                    </th>

                    <th>
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach($students as $student)

                    <tr>

                        {{-- STUDENT ID --}}

                        <td>

                            <span class="student-id">

                                {{ $student->student_id }}

                            </span>

                        </td>


                        {{-- STUDENT NAME --}}

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
                                        Student
                                    </span>

                                </div>

                            </div>

                        </td>


                        {{-- EMAIL --}}

                        <td>

                            {{ $student->email ?? '—' }}

                        </td>


                        {{-- COURSE --}}

                        <td>

                            <span class="badge badge-blue">

                                {{ $student->course }}

                            </span>

                        </td>


                        {{-- YEAR --}}

                        <td>

                            <span class="badge badge-green">

                                {{ $student->year_level }}

                            </span>

                        </td>


                        {{-- ACTIONS --}}

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('students.edit', $student) }}"
                                    class="btn btn-small btn-edit"
                                >
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


{{-- ==========================================
     NO STUDENTS
========================================== --}}

@else

    <div class="empty-state">

        <div class="empty-icon">
            👥
        </div>

        <h3>
            No Students Found
        </h3>

        <p>
            Start by adding your first student.
        </p>

        <a
            href="{{ route('students.create') }}"
            class="btn btn-primary"
        >
            + Add Student
        </a>

    </div>

@endif

</div>

{{-- ==========================================
IMPORT STUDENTS MODAL
========================================== --}}

<div id="importModal" class="import-modal" style="display: none;">

    <div class="import-modal-content">

        <div class="import-header">

            <div>
                <h2>Import Students</h2>

                <p>
                    Upload an Excel file to add multiple students.
                </p>
            </div>

            <button type="button"
                    class="close-modal"
                    onclick="closeImportModal()">
                &times;
            </button>

        </div>


        <div class="import-instructions">

            <h3>Excel Format</h3>

            <p>
                Your Excel file must contain these columns:
            </p>

            <code>
                student_id, first_name, last_name, email, course, year_level
            </code>

        </div>


        <form action="{{ route('students.import') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="file-upload">

                <label for="student_file">
                    Select Excel File
                </label>

                <input
                    type="file"
                    id="student_file"
                    name="file"
                    accept=".xlsx,.xls,.csv"
                    required
                >

                <small>
                    Supported formats: .xlsx, .xls, .csv
                    (Maximum 5MB)
                </small>

            </div>


            <div class="import-actions">

                <button type="button"
                        class="btn-secondary"
                        onclick="closeImportModal()">
                    Cancel
                </button>

                <button type="submit"
                        class="btn-primary">
                    Import Students
                </button>

            </div>

        </form>

    </div>

</div>

{{-- ==========================================
SEARCH SCRIPT
========================================== --}}

@push('scripts')

<script>

    const searchInput =
        document.getElementById('studentSearch');

    const table =
        document.getElementById('studentsTable');


    if (searchInput && table) {

        searchInput.addEventListener('input', function () {

            const searchValue =
                this.value.toLowerCase().trim();

            const rows =
                table.querySelectorAll('tbody tr');


            rows.forEach(function (row) {

                const rowText =
                    row.textContent.toLowerCase();

                if (rowText.includes(searchValue)) {

                    row.style.display = '';

                } else {

                    row.style.display = 'none';

                }

            });

        });

    }

</script>

<script>
function openImportModal() {
    document.getElementById('importModal').style.display = 'flex';
}

function closeImportModal() {
    document.getElementById('importModal').style.display = 'none';
}

window.addEventListener('click', function(event) {

    const modal = document.getElementById('importModal');

    if (event.target === modal) {
        closeImportModal();
    }

});
</script>

@endpush

@endsection
