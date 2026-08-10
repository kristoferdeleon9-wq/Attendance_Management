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

    <aside class="sidebar">

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

            <a
                href="{{ route('dashboard') }}"
                class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                >
            <span>▣</span>
                Dashboard
            </a>


            <p class="menu-title">
                MANAGEMENT
            </p>

            <a
                href="{{ route('students.index') }}"
                class="menu-item {{ request()->routeIs('students.*') ? 'active' : '' }}"
            >
                <span>👥</span>
                Students
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


            <p class="menu-title">
                ATTENDANCE
            </p>

            <a
                href="#"
                class="menu-item"
            >
                <span>▣</span>
                QR Scanner
            </a>

            <a
                href="#"
                class="menu-item"
            >
                <span>✓</span>
                Attendance
            </a>

            <a
                href="#"
                class="menu-item"
            >
                <span>📊</span>
                Reports
            </a>


            <p class="menu-title">
                SYSTEM
            </p>

            <a
                href="#"
                class="menu-item"
            >
                <span>⚙</span>
                Settings
            </a>

        </div>


        <div class="sidebar-footer">

            <div class="user-avatar">
                A
            </div>

            <div class="user-info">

                <strong>
                    Administrator
                </strong>

                <span>
                    Admin
                </span>

            </div>

        </div>

    </aside>


    {{-- ==========================================
         MAIN CONTENT
    =========================================== --}}

    <main class="main-content">


        {{-- TOP BAR --}}

        <header class="topbar">

            <div>

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
                        A
                    </div>

                    <div>

                        <strong>
                            Administrator
                        </strong>

                        <small>
                            Admin
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
@stack('scripts')
</body>

</html>