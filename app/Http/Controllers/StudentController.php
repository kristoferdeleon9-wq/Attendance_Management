<?php

namespace App\Http\Controllers;

use App\Models\Student;
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
        $section = \App\Models\Section::findOrFail(
            $request->section_id
        );

        return view('students.create', compact('section'));
    }

    // Save student
    public function store(Request $request)
    {
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