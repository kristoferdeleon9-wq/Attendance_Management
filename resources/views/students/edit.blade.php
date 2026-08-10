<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>

<body>

<h1>Edit Student</h1>

@if($errors->any())

    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

@endif

<form
    action="{{ route('students.update', $student) }}"
    method="POST"
>

    @csrf
    @method('PUT')

    <label>Student ID</label>
    <br>

    <input
        type="text"
        name="student_id"
        value="{{ old('student_id', $student->student_id) }}"
    >

    <br><br>

    <label>First Name</label>
    <br>

    <input
        type="text"
        name="first_name"
        value="{{ old('first_name', $student->first_name) }}"
    >

    <br><br>

    <label>Last Name</label>
    <br>

    <input
        type="text"
        name="last_name"
        value="{{ old('last_name', $student->last_name) }}"
    >

    <br><br>

    <label>Email</label>
    <br>

    <input
        type="email"
        name="email"
        value="{{ old('email', $student->email) }}"
    >

    <br><br>

    <label>Course</label>
    <br>

    <input
        type="text"
        name="course"
        value="{{ old('course', $student->course) }}"
    >

    <br><br>

    <label>Year Level</label>
    <br>

    <input
        type="text"
        name="year_level"
        value="{{ old('year_level', $student->year_level) }}"
    >

    <br><br>

    <button type="submit">
        Update Student
    </button>

</form>

<br>

<a href="{{ route('students.index') }}">
    Back to Students
</a>

</body>
</html>