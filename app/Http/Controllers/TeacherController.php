<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display all teachers.
     */
    public function index()
    {
        $teachers = Teacher::latest()->get();

        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show create teacher form.
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store teacher.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|string|max:50|unique:teachers,teacher_id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'department' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
        ]);

        Teacher::create($validated);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher added successfully.');
    }

    /**
     * Show edit teacher form.
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    /**
     * Update teacher.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|string|max:50|unique:teachers,teacher_id,' . $teacher->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'department' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
        ]);

        $teacher->update($validated);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Delete teacher.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}