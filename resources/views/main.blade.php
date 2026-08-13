<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>AttendEase | Attendance Management System</title>

    @vite('resources/css/main.css')

</head>

<body>


{{-- =========================================================
     NAVBAR
========================================================= --}}

<nav class="navbar">

    <div class="navbar-logo">

        <div class="logo-icon">
            A
        </div>

        <div class="logo-text">
            <strong>AttendEase</strong>
            <span>Management System</span>
        </div>

    </div>


    <div class="navbar-links">

        <a href="#features">
            Features
        </a>

        <a href="#how-it-works">
            How It Works
        </a>

        <a href="#about">
            About
        </a>

    </div>

    <!-- STUDENT ACCESS -->
<section class="student-access">

    <div class="student-access-content">

        <div class="student-icon">
            👨‍🎓
        </div>

        <div class="student-text">

            <span class="student-label">
                STUDENT
            </span>

            <h2>
                As a Student
            </h2>

            <p>
                Access your attendance information, view your QR code,
                and check your attendance records.
            </p>

            <a
                href="{{ route('student.access') }}"
                class="student-button"
            >
                Continue as Student
                <span>→</span>
            </a>

        </div>

    </div>

</section>


    <div class="navbar-actions">

        <a
            href="{{ route('login') }}"
            class="login-btn"
        >
            Login
        </a>

        <a
            href="{{ route('login') }}"
            class="signup-btn"
        >
            Get Started
        </a>

    </div>

</nav>



{{-- =========================================================
     HERO
========================================================= --}}

<section class="hero">

    <div class="hero-content">

        <div class="hero-badge">
            ✓ Modern Attendance Management
        </div>


        <h1>

            Smarter Attendance.

            <span>
                Simpler Management.
            </span>

        </h1>


        <p>

            AttendEase helps schools manage student attendance,
            classes, teachers, and attendance records using a
            simple and efficient QR code system.

        </p>


        <div class="hero-buttons">

            <a
                href="{{ route('login') }}"
                class="hero-primary"
            >
                Get Started
                <span>→</span>
            </a>


            <a
                href="#features"
                class="hero-secondary"
            >
                Explore Features
            </a>

        </div>


        <div class="hero-stats">

            <div>
                <strong>QR</strong>
                <span>Attendance</span>
            </div>

            <div>
                <strong>24/7</strong>
                <span>Accessible</span>
            </div>

            <div>
                <strong>100%</strong>
                <span>Digital</span>
            </div>

        </div>

    </div>


    {{-- HERO CARD --}}

    <div class="hero-visual">

        <div class="dashboard-preview">

            <div class="preview-header">

                <div>
                    <small>Today's Attendance</small>

                    <h3>
                        Class Attendance
                    </h3>
                </div>

                <div class="preview-status">
                    ● LIVE
                </div>

            </div>


            <div class="preview-stats">

                <div>
                    <span>Present</span>
                    <strong>32</strong>
                </div>

                <div>
                    <span>Late</span>
                    <strong>4</strong>
                </div>

                <div>
                    <span>Absent</span>
                    <strong>3</strong>
                </div>

            </div>


            <div class="preview-progress">

                <div class="progress-header">
                    <span>Attendance Rate</span>
                    <strong>82%</strong>
                </div>

                <div class="progress-bar">

                    <div class="progress-fill"></div>

                </div>

            </div>


            <div class="preview-list">

                <div class="student-row">

                    <div class="student-avatar">
                        JD
                    </div>

                    <div>
                        <strong>Juan Dela Cruz</strong>
                        <span>2026-001</span>
                    </div>

                    <b class="present">
                        Present
                    </b>

                </div>


                <div class="student-row">

                    <div class="student-avatar">
                        MS
                    </div>

                    <div>
                        <strong>Maria Santos</strong>
                        <span>2026-002</span>
                    </div>

                    <b class="late">
                        Late
                    </b>

                </div>


                <div class="student-row">

                    <div class="student-avatar">
                        AP
                    </div>

                    <div>
                        <strong>Alex Perez</strong>
                        <span>2026-003</span>
                    </div>

                    <b class="present">
                        Present
                    </b>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
     FEATURES
========================================================= --}}

<section
    class="features-section"
    id="features"
>

    <div class="section-header">

        <span>
            FEATURES
        </span>

        <h2>
            Everything you need to manage attendance
        </h2>

        <p>
            A complete attendance management system designed
            to make daily attendance faster and easier.
        </p>

    </div>


    <div class="features-grid">


        {{-- QR --}}

        <div class="feature-card">

            <div class="feature-icon purple">
                ▣
            </div>

            <h3>
                QR Code Attendance
            </h3>

            <p>
                Quickly record student attendance by scanning
                their unique QR code.
            </p>

        </div>


        {{-- STUDENTS --}}

        <div class="feature-card">

            <div class="feature-icon blue">
                👨‍🎓
            </div>

            <h3>
                Student Management
            </h3>

            <p>
                Add, update, search, and organize student
                information in one place.
            </p>

        </div>


        {{-- TEACHERS --}}

        <div class="feature-card">

            <div class="feature-icon green">
                👨‍🏫
            </div>

            <h3>
                Teacher Management
            </h3>

            <p>
                Manage teacher accounts and organize instructors
                assigned to classes.
            </p>

        </div>


        {{-- CLASSES --}}

        <div class="feature-card">

            <div class="feature-icon orange">
                📚
            </div>

            <h3>
                Classes & Sections
            </h3>

            <p>
                Organize classes, subjects, rooms, teachers,
                and sections efficiently.
            </p>

        </div>


        {{-- REPORTS --}}

        <div class="feature-card">

            <div class="feature-icon red">
                📊
            </div>

            <h3>
                Attendance Reports
            </h3>

            <p>
                View attendance records and analyze present,
                late, absent, and excused students.
            </p>

        </div>


        {{-- SECURITY --}}

        <div class="feature-card">

            <div class="feature-icon teal">
                🔐
            </div>

            <h3>
                Role-Based Access
            </h3>

            <p>
                Separate Admin and Teacher access to keep
                important system features protected.
            </p>

        </div>

    </div>

</section>



{{-- =========================================================
     HOW IT WORKS
========================================================= --}}

<section
    class="how-section"
    id="how-it-works"
>

    <div class="section-header">

        <span>
            HOW IT WORKS
        </span>

        <h2>
            Attendance in three simple steps
        </h2>

        <p>
            Make classroom attendance quick and convenient.
        </p>

    </div>


    <div class="steps">


        <div class="step">

            <div class="step-number">
                01
            </div>

            <div class="step-icon">
                🔐
            </div>

            <h3>
                Login
            </h3>

            <p>
                Admins and teachers securely log into
                the attendance system.
            </p>

        </div>


        <div class="step-line"></div>


        <div class="step">

            <div class="step-number">
                02
            </div>

            <div class="step-icon">
                ▶
            </div>

            <h3>
                Start Session
            </h3>

            <p>
                The teacher selects a class and starts
                an attendance session.
            </p>

        </div>


        <div class="step-line"></div>


        <div class="step">

            <div class="step-number">
                03
            </div>

            <div class="step-icon">
                ▣
            </div>

            <h3>
                Scan QR Code
            </h3>

            <p>
                Students present their QR codes while the
                teacher scans them.
            </p>

        </div>

    </div>

</section>



{{-- =========================================================
     ABOUT
========================================================= --}}

<section
    class="about-section"
    id="about"
>

    <div class="about-content">

        <span class="about-label">
            ABOUT ATTENDEASE
        </span>

        <h2>
            Built to make attendance easier.
        </h2>

        <p>
            AttendEase is an attendance management system
            designed to simplify the way schools record,
            manage, and review student attendance.
        </p>

        <p>
            Instead of relying on manual attendance sheets,
            teachers can use QR code scanning to quickly
            record student attendance.
        </p>


        <div class="about-points">

            <div>
                ✓ Faster attendance recording
            </div>

            <div>
                ✓ Organized student records
            </div>

            <div>
                ✓ Easy attendance monitoring
            </div>

            <div>
                ✓ Detailed attendance reports
            </div>

        </div>

    </div>


    <div class="about-card">

        <div class="about-card-icon">
            A
        </div>

        <h3>
            AttendEase
        </h3>

        <p>
            Attendance Management System
        </p>

        <div class="about-card-line"></div>

        <small>
            Simple • Fast • Organized
        </small>

    </div>

</section>



{{-- =========================================================
     CALL TO ACTION
========================================================= --}}

<section class="cta-section">

    <div>

        <span>
            READY TO GET STARTED?
        </span>

        <h2>
            Make attendance management easier today.
        </h2>

        <p>
            Login to your AttendEase account and start
            managing attendance.
        </p>

    </div>


    <a
        href="{{ route('login') }}"
        class="cta-button"
    >
        Login to AttendEase
        →
    </a>

</section>



{{-- =========================================================
     FOOTER
========================================================= --}}

<footer class="footer">

    <div class="footer-main">

        <div class="footer-brand">

            <div class="navbar-logo">

                <div class="logo-icon">
                    A
                </div>

                <div class="logo-text">

                    <strong>
                        AttendEase
                    </strong>

                    <span>
                        Management System
                    </span>

                </div>

            </div>


            <p>
                A simple and efficient solution for
                modern attendance management.
            </p>

        </div>


        <div class="footer-links">

            <strong>
                Quick Links
            </strong>

            <a href="#features">
                Features
            </a>

            <a href="#how-it-works">
                How It Works
            </a>

            <a href="#about">
                About
            </a>

            <a href="{{ route('login') }}">
                Login
            </a>

        </div>


        <div class="footer-links">

            <strong>
                System
            </strong>

            <span>
                QR Attendance
            </span>

            <span>
                Student Management
            </span>

            <span>
                Teacher Management
            </span>

            <span>
                Attendance Reports
            </span>

        </div>

    </div>


    <div class="footer-bottom">

        <span>
            © {{ date('Y') }} AttendEase. All rights reserved.
        </span>

        <span>
            Attendance Management System
        </span>

    </div>

</footer>


</body>

</html>