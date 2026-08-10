<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display all classes.
     */
    public function index()
    {
        $classes = SchoolClass::latest()->get();

        return view('classes.index', compact('classes'));
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view('classes.create');
    }


    /**
     * Store a new class.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',

            'subject' => 'required|string|max:255',

            'section' => 'required|string|max:100',

            'schedule' => 'nullable|string|max:255',

            'room' => 'nullable|string|max:100',

            'description' => 'nullable|string',
        ]);

        SchoolClass::create($validated);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class created successfully.');
    }


    /**
     * Show class.
     */
    public function show(SchoolClass $class)
    {
        return view('classes.show', compact('class'));
    }


    /**
     * Show edit form.
     */
    public function edit(SchoolClass $class)
    {
        return view('classes.edit', compact('class'));
    }


    /**
     * Update class.
     */
    public function update(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',

            'subject' => 'required|string|max:255',

            'section' => 'required|string|max:100',

            'schedule' => 'nullable|string|max:255',

            'room' => 'nullable|string|max:100',

            'description' => 'nullable|string',
        ]);

        $class->update($validated);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class updated successfully.');
    }


    /**
     * Delete class.
     */
    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class deleted successfully.');
    }
}