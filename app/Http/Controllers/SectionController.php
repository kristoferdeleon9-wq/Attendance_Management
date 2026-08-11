<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('students')
            ->latest()
            ->get();

        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        return view('sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'adviser' => 'required|string|max:255',
            'year_level' => 'required|string|max:100',
            'school_year' => 'required|string|max:100',
        ]);

        Section::create($validated);

        return redirect()
            ->route('sections.index')
            ->with('success', 'Section created successfully.');
    }

    public function show(Section $section)
    {
        $section->load('students');

        return view('sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        return view('sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'adviser' => 'required|string|max:255',
            'year_level' => 'required|string|max:100',
            'school_year' => 'required|string|max:100',
        ]);

        $section->update($validated);

        return redirect()
            ->route('sections.index')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        // Remove students from the section first
        Student::where('section_id', $section->id)
            ->update(['section_id' => null]);

        $section->delete();

        return redirect()
            ->route('sections.index')
            ->with('success', 'Section deleted successfully.');
    }
}