@extends('layouts.app')

@section('title', 'Settings')

@section('page-title', 'Settings')

@push('styles')
    @vite('resources/css/settings.css')
@endpush

@section('content')

<div class="settings-page">

    <div class="settings-header">
        <h1>Settings</h1>

        <p>
            Manage your account and system preferences.
        </p>
    </div>


    {{-- ACCOUNT --}}
    <div class="settings-card">

        <h2>Account</h2>

        <p>
            Information about your current account.
        </p>

        <div class="setting-row">

            <div class="setting-info">
                <strong>Name</strong>

                <span>
                    {{ auth()->user()->name }}
                </span>
            </div>

        </div>


        <div class="setting-row">

            <div class="setting-info">
                <strong>Email</strong>

                <span>
                    {{ auth()->user()->email }}
                </span>
            </div>

        </div>


        <div class="setting-row">

            <div class="setting-info">
                <strong>Role</strong>

                <span>
                    Your account permission level
                </span>
            </div>

            <span class="role-badge">
                {{ ucfirst(auth()->user()->role) }}
            </span>

        </div>

    </div>


    {{-- SECURITY --}}
    <div class="settings-card">

        <h2>Security</h2>

        <p>
            Manage your account security.
        </p>

        <div class="setting-row">

            <div class="setting-info">

                <strong>
                    Change Password
                </strong>

                <span>
                    Update your account password.
                </span>

            </div>

            <a
                href="#"
                class="settings-btn"
            >
                Change Password
            </a>

        </div>

    </div>


    {{-- SYSTEM --}}
    @if(auth()->user()->role === 'admin')

        <div class="settings-card">

            <h2>System Settings</h2>

            <p>
                Administrator-only system settings.
            </p>

            <div class="setting-row">

                <div class="setting-info">

                    <strong>
                        User Management
                    </strong>

                    <span>
                        Manage administrator and teacher accounts.
                    </span>

                </div>

                <a
                    href="#"
                    class="settings-btn"
                >
                    Manage Users
                </a>

            </div>

        </div>

    @endif

</div>

@endsection