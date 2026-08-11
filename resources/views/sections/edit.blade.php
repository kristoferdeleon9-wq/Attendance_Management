@extends('layouts.app')

@section('title', 'Edit Section')

@section('page-title', 'Sections')

@push('styles')
    @vite('resources/css/sections.css')
@endpush

@section('content')

<div class="section-header">

    <div class="header-left">

        <h1>Edit Section</h1>

        <p>
            Update the information for {{ $section->name }}.
        </p>

    </div>

    <div class="page-actions">

        <a
            href="{{ route('sections.index') }}"
            class="btn-secondary"
        >
            ← Back to Sections
        </a>

        <a
            href="{{ route('sections.show', $section) }}"
            class="btn btn-primary"
        >
            View Section
        </a>

    </div>

</div>


<div class="form-card">

    <div class="form-header">

        <h1>Section Information</h1>

        <p>
            Update the section details below.
        </p>

    </div>


    <form
        action="{{ route('sections.update', $section) }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        {{-- NAME --}}

        <div class="form-group">

            <label for="name">
                Section Name
                <span style="color: #dc2626;">*</span>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $section->name) }}"
                placeholder="e.g. BSIT 4A"
                required
            >

            @error('name')
                <span class="error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- ADVISER --}}

        <div class="form-group">

            <label for="adviser">
                Adviser
                <span style="color: #dc2626;">*</span>
            </label>

            <input
                type="text"
                id="adviser"
                name="adviser"
                value="{{ old('adviser', $section->adviser) }}"
                placeholder="e.g. Juan Dela Cruz"
                required
            >

            @error('adviser')
                <span class="error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- YEAR LEVEL --}}

        <div class="form-group">

            <label for="year_level">
                Year Level
                <span style="color: #dc2626;">*</span>
            </label>

            <select
                id="year_level"
                name="year_level"
                required
            >

                <option value="">
                    Select year level
                </option>

                <option
                    value="1st Year"
                    {{ old('year_level', $section->year_level) == '1st Year' ? 'selected' : '' }}
                >
                    1st Year
                </option>

                <option
                    value="2nd Year"
                    {{ old('year_level', $section->year_level) == '2nd Year' ? 'selected' : '' }}
                >
                    2nd Year
                </option>

                <option
                    value="3rd Year"
                    {{ old('year_level', $section->year_level) == '3rd Year' ? 'selected' : '' }}
                >
                    3rd Year
                </option>

                <option
                    value="4th Year"
                    {{ old('year_level', $section->year_level) == '4th Year' ? 'selected' : '' }}
                >
                    4th Year
                </option>

            </select>

            @error('year_level')
                <span class="error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- SCHOOL YEAR --}}

        <div class="form-group">

            <label for="school_year">
                School Year
                <span style="color: #dc2626;">*</span>
            </label>

            <input
                type="text"
                id="school_year"
                name="school_year"
                value="{{ old('school_year', $section->school_year) }}"
                placeholder="e.g. 2026-2027"
                required
            >

            @error('school_year')
                <span class="error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- ACTIONS --}}

        <div class="form-actions">

            <a
                href="{{ route('sections.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                ✓ Update Section
            </button>

        </div>

    </form>

</div>

@endsection