<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Attendance Management System')
    </title>

    @vite('resources/css/app.css')
    @stack('styles')

</head>

<body>

<div class="app-layout">


    {{-- ==========================================
         SIDEBAR
    =========================================== --}}

    <aside class="sidebar" id="sidebar">

        <div class="sidebar-logo">

            <div class="logo-icon">
                A
            </div>

            <div>
                <h2>AttendEase</h2>
                <span>Management System</span>
            </div>

        </div>


        <div class="sidebar-menu">

    <p class="menu-title">
        MAIN
    </p>

    {{-- DASHBOARD --}}
    <a
        href="{{ route('dashboard') }}"
        class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
    >
        <span>▣</span>
        Dashboard
    </a>


    {{-- MANAGEMENT --}}
    <p class="menu-title">
        MANAGEMENT
    </p>


    {{-- ADMIN ONLY --}}
    @if(auth()->user()->role === 'admin')

        <a
            href="{{ route('students.index') }}"
            class="menu-item {{ request()->routeIs('students.*') ? 'active' : '' }}"
        >
            <span>👨‍🎓</span>
            Students
        </a>


        <a
            href="{{ route('sections.index') }}"
            class="menu-item {{ request()->routeIs('sections.*') ? 'active' : '' }}"
        >
            <span>💠</span>
            Sections
        </a>


        <a
            href="{{ route('teachers.index') }}"
            class="menu-item {{ request()->routeIs('teachers.*') ? 'active' : '' }}"
        >
            <span>👨‍🏫</span>
            Teachers
        </a>


        <a
            href="{{ route('classes.index') }}"
            class="menu-item {{ request()->routeIs('classes.*') ? 'active' : '' }}"
        >
            <span>📚</span>
            Classes
        </a>

    @endif


    {{-- ATTENDANCE --}}
    <p class="menu-title">
        ATTENDANCE
    </p>


    @if(in_array(auth()->user()->role, ['admin', 'teacher']))

        <a
            href="{{ route('attendance.index') }}"
            class="menu-item {{ request()->routeIs('attendance.*') ? 'active' : '' }}"
        >
            <span>✓</span>
            Attendance
        </a>


        <a
            href="{{ route('reports.index') }}"
            class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}"
        >
            <span>📊</span>
            Reports
        </a>

    @endif


    {{-- SYSTEM --}}
    <p class="menu-title">
        SYSTEM
    </p>

    <a
        href="{{ route('settings') }}"
        class="menu-item {{ request()->routeIs('settings') ? 'active' : '' }}"
    >
        <span>⚙</span>
        Settings
    </a>

</div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="logout-btn">
                🚪 Logout
            </button>
        </form>


        <div class="sidebar-footer">

    <div class="user-avatar">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </div>

    <div class="user-info">

        <strong>
            {{ auth()->user()->name }}
        </strong>

        <span>
            {{ ucfirst(auth()->user()->role) }}
        </span>

    </div>

</div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>


    {{-- ==========================================
         MAIN CONTENT
    =========================================== --}}

    <main class="main-content">


        {{-- TOP BAR --}}

        <header class="topbar">

    <div class="topbar-left">

        <button
            type="button"
            id="sidebarToggle"
            class="sidebar-toggle"
            aria-label="Toggle navigation"
        >
            ☰
        </button>

        <h3>
            @yield('page-title', 'Dashboard')
        </h3>

    </div>


            <div class="topbar-right">

                <button class="notification">
                    🔔
                    <span></span>
                </button>

                <div class="topbar-user">

                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div>

                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <small>
                            {{ ucfirst(auth()->user()->role) }}
                        </small>

                    </div>

                </div>

            </div>

        </header>


        {{-- PAGE CONTENT --}}

        <section class="page-content">

            @yield('content')

        </section>


    </main>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    if (!sidebar || !toggle) {
        return;
    }

    toggle.addEventListener('click', function () {

        if (window.innerWidth <= 700) {

            sidebar.classList.toggle('mobile-open');

            if (overlay) {
                overlay.classList.toggle('show');
            }

        } else {

            sidebar.classList.toggle('collapsed');

        }

    });


    // Close sidebar when clicking outside on phone
    if (overlay) {

        overlay.addEventListener('click', function () {

            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('show');

        });

    }


    // Close mobile sidebar when clicking a menu item
    document.querySelectorAll('.sidebar .menu-item').forEach(function (item) {

        item.addEventListener('click', function () {

            if (window.innerWidth <= 700) {

                sidebar.classList.remove('mobile-open');

                if (overlay) {
                    overlay.classList.remove('show');
                }

            }

        });

    });

});
</script>

@stack('scripts')
</body>

</html>