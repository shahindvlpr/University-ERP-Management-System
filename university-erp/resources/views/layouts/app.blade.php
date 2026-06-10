<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University ERP - @yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        body{
            background:linear-gradient(135deg,#f4f6f9,#eef2ff);
            font-family:'Segoe UI',sans-serif;
            overflow-x:hidden;
        }

        /* Sidebar */

        .sidebar{
            width:250px;
            height:100vh;
            background:#1a237e;
            color:#fff;
            position:fixed;
            top:0;
            left:0;
            overflow-y:auto;
            overflow-x:hidden;
            z-index:1000;
            scrollbar-width:thin;
            scrollbar-color:rgba(255,255,255,.4) transparent;
        }

        .sidebar::-webkit-scrollbar{
            width:6px;
        }

        .sidebar::-webkit-scrollbar-track{
            background:transparent;
        }

        .sidebar::-webkit-scrollbar-thumb{
            background:rgba(255,255,255,.3);
            border-radius:20px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover{
            background:rgba(255,255,255,.5);
        }

        .sidebar .nav-link{
            color:rgba(255,255,255,.85);
            padding:12px 20px;
            border-radius:8px;
            margin:3px 8px;
            transition:.3s;
        }

        .sidebar .nav-link:hover{
            background:rgba(255,255,255,.15);
            color:#fff;
            transform:translateX(5px);
        }

        .sidebar .nav-link.active{
            background:rgba(255,255,255,.15);
            border-left:4px solid #ffc107;
            color:#fff;
        }

        .sidebar .nav-link i{
            margin-right:10px;
        }

        /* Main Content */

        .main-content{
            margin-left:250px;
            padding:20px;
        }

        /* Topbar */

        .topbar{
            background:#fff;
            padding:15px 20px;
            margin:-20px -20px 20px;
            box-shadow:0 4px 15px rgba(0,0,0,.08);
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        /* Cards */

        .card{
            border:none;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,.08);
            transition:.3s;
        }

        .card:hover{
            transform:translateY(-3px);
            box-shadow:0 8px 20px rgba(0,0,0,.12);
        }

        /* Stats */

        .stat-card{
            border-radius:15px;
            transition:.3s;
        }

        .stat-card:hover{
            transform:scale(1.03);
        }

        /* User Avatar */

        .user-avatar{
            width:40px;
            height:40px;
            border-radius:50%;
            background:#0d6efd;
            color:#fff;
            display:flex;
            justify-content:center;
            align-items:center;
            font-weight:bold;
        }

        /* Mobile */

        @media(max-width:768px){

            .sidebar{
                width:100%;
                position:relative;
                height:auto;
            }

            .main-content{
                margin-left:0;
            }

            .topbar{
                flex-direction:column;
                align-items:flex-start;
                gap:10px;
            }
        }

    </style>

</head>
<body>

<!-- Sidebar -->

<div class="sidebar d-flex flex-column p-3">

    <div class="text-center mb-3 mt-2">

        <i class="bi bi-mortarboard-fill fs-1 text-warning"></i>

        <h4 class="fw-bold mt-1 mb-0">
            UniERP
        </h4>

        <small class="opacity-75">
            University Management System
        </small>

    </div>

    <nav class="nav flex-column gap-1">

        <small class="text-uppercase text-white-50 px-3 mb-2">
            Main
        </small>

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        @role('admin')

        <hr class="border-light opacity-25">

        <small class="text-uppercase text-white-50 px-3 mb-2">
            Academic
        </small>

        <a href="{{ route('departments.index') }}"
           class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            Departments
        </a>

        <a href="{{ route('students.index') }}"
           class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            Students
        </a>

        <a href="{{ route('teachers.index') }}"
           class="nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
            <i class="bi bi-person-workspace"></i>
            Teachers
        </a>

        <a href="{{ route('courses.index') }}"
           class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i>
            Courses
        </a>

        <hr class="border-light opacity-25">

        <small class="text-uppercase text-white-50 px-3 mb-2">
            Management
        </small>

        <a href="{{ route('fees.index') }}"
           class="nav-link {{ request()->routeIs('fees.*') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i>
            Fees
        </a>

        <a href="{{ route('notices.index') }}"
           class="nav-link {{ request()->routeIs('notices.*') ? 'active' : '' }}">
            <i class="bi bi-megaphone"></i>
            Notices
        </a>

        <a href="{{ route('reports.index') }}"
           class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i>
            Reports
        </a>

        @endrole

        <hr class="border-light opacity-25">

        <small class="text-uppercase text-white-50 px-3 mb-2">
            Examination
        </small>

        @role('admin|teacher')

        <a href="{{ route('attendance.index') }}"
           class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            Attendance
        </a>

        <a href="{{ route('enrollments.index') }}"
            class="nav-link {{ request()->routeIs('enrollments.*') ? 'active' : '' }}">

            <i class="bi bi-journal-check"></i>
            Enrollments

        </a>

        <a href="{{ route('results.index') }}"
           class="nav-link {{ request()->routeIs('results.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i>
            Results
        </a>

        <a href="{{ route('routines.index') }}"
        class="nav-link {{ request()->routeIs('routines.*') ? 'active' : '' }}">

            <i class="bi bi-calendar-week"></i>
            Routine

        </a>
        <a href="{{ route('books.index') }}"
        class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">

            <i class="bi bi-book-half"></i>
            Library Books

        </a>


<a href="{{ route('book-issues.index') }}"
   class="nav-link">

    <i class="bi bi-journal-check"></i>
    Book Issues

</a>
<a href="{{ route('exams.index') }}"
   class="nav-link {{ request()->routeIs('exams.*') ? 'active' : '' }}">

    <i class="bi bi-journal-text"></i>
    Exams

</a>
<a href="{{ route('exam-marks.index') }}"
   class="nav-link">

    <i class="bi bi-pencil-square"></i>

    Exam Marks

</a>











        @endrole

    </nav>

    <div class="mt-auto pt-3">

        <form method="POST"
              action="{{ route('logout') }}">

            @csrf

            <button class="btn btn-outline-light w-100">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </button>

        </form>

    </div>

</div>

<!-- Main Content -->

<div class="main-content">

    <div class="topbar">

        <h5 class="mb-0 fw-bold">
            <i class="bi bi-speedometer2"></i>
            @yield('title','Dashboard')
        </h5>

        <div class="d-flex align-items-center gap-2">

            <span class="badge bg-primary">
                {{ auth()->user()->getRoleNames()->first() }}
            </span>

            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>

            <span class="fw-semibold">
                {{ auth()->user()->name }}
            </span>

        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>

