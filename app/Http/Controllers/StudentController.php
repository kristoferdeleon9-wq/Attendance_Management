<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    // Display all students
    public function index()
    {
        $students = Student::latest()->get();

        return view('students.index', compact('students'));
    }

    public function create(Request $request)
    {
        $sections = \App\Models\Section::orderBy('name')->get();

        $section = null;

        if ($request->filled('section_id')) {
            $section = \App\Models\Section::findOrFail(
                $request->section_id
            );
        }

        return view('students.create', compact('sections', 'section'));
    }

    public function studentRegister()
    {
        $sections = Section::orderBy('name')->get();

        return view('student-register', compact('sections'));
    }

    public function studentStore(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|max:50|unique:students,student_id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'section_id' => 'required|exists:sections,id',
            'email' => 'nullable|email|max:255',
            'course' => 'nullable|string|max:100',
            'year_level' => 'nullable|string|max:50',
        ]);

        Student::create($validated);

        return redirect()
            ->route('student.register')
            ->with('success', 'Your student information has been registered successfully.');
    }

    // Save student
    public function store(Request $request)
    {
        if (Student::where('student_id', $request->student_id)->exists()) {
            return back()
                ->withInput()
                ->with('error', 'This student is already registered.');
        }

        $validated = $request->validate([
            'student_id' => 'required|string|max:255|unique:students,student_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:100',
            'section_id' => 'required|exists:sections,id',
        ]);

        Student::create($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student added successfully!');
    }

    // Show edit form
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    // Update student
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id,' . $student->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email',
            'course' => 'nullable',
            'year_level' => 'nullable',
        ]);

        $student->update($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    // Delete student
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => [
            'required',
            'file',
            'mimes:xlsx,xls,csv',
            'max:5120',
        ],
    ]);

    try {

        $import = new StudentsImport();

        Excel::import(
            $import,
            $request->file('file')
        );

        return redirect()
            ->route('students.index')
            ->with(
                'success',
                $import->imported .
                ' student(s) imported successfully. ' .
                $import->skipped .
                ' student(s) skipped.'
            );

    } catch (\Exception $e) {

        return redirect()
            ->route('students.index')
            ->with(
                'error',
                'Import failed: ' . $e->getMessage()
            );
    }
}
}