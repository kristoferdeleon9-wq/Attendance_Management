@extends('layouts.app')

@section('title', 'Create Section')

@section('page-title', 'Create Section')

@section('content')

<div class="form-card">

    <div class="form-header">

        <h1>
            Create Section
        </h1>

        <p>
            Create a section before adding students.
        </p>

    </div>


    <form action="{{ route('sections.store') }}"
          method="POST">

        @csrf


        <div class="form-group">

            <label for="name">
                Section Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Example: BSIT 1-A"
                required
            >

            @error('name')
                <small class="error">{{ $message }}</small>
            @enderror

        </div>


        <div class="form-group">

            <label for="adviser">
                Adviser
            </label>

            <input
                type="text"
                id="adviser"
                name="adviser"
                value="{{ old('adviser') }}"
                placeholder="Section adviser"
                required
            >

            @error('adviser')
                <small class="error">{{ $message }}</small>
            @enderror

        </div>


        <div class="form-row">

            <div class="form-group">

                <label for="year_level">
                    Year Level
                </label>

                <select
                    id="year_level"
                    name="year_level"
                    required
                >

                    <option value="">
                        Select Year Level
                    </option>

                    <option value="1st Year">
                        1st Year
                    </option>

                    <option value="2nd Year">
                        2nd Year
                    </option>

                    <option value="3rd Year">
                        3rd Year
                    </option>

                    <option value="4th Year">
                        4th Year
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label for="school_year">
                    School Year
                </label>

                <input
                    type="text"
                    id="school_year"
                    name="school_year"
                    value="{{ old('school_year') }}"
                    placeholder="2026-2027"
                    required
                >

            </div>

        </div>


        <div class="form-actions">

            <a href="{{ route('sections.index') }}"
               class="btn-secondary">

                Cancel

            </a>

            <button type="submit"
                    class="btn btn-primary">

                Create Section

            </button>

        </div>

    </form>

</div>

@endsection