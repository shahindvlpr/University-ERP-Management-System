```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University ERP - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg,#f4f6f9,#eef2ff);
            font-family: 'Segoe UI', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1a237e;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.80);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 3px 8px;
            transition: all .3s ease;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border-left: 4px solid #ffc107;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Topbar */
        .topbar {
            background: #fff;
            padding: 15px 20px;
            margin: -20px -20px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
            transition: all .3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,.12);
        }

        /* Stat Cards */
        .stat-card {
            border-radius: 15px;
            transition: .3s;
        }

        .stat-card:hover {
            transform: scale(1.03);
        }

        /* Tables */
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background: #1a237e;
            color: white;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        /* User Avatar */
        .user-avatar {
            width: 40px;
            height: 40px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #1a237e;
            border-radius: 10px;
        }

        /* Mobile */
        @media(max-width:768px){

            .sidebar{
                width: 100%;
                position: relative;
                min-height: auto;
            }

            .main-content{
                margin-left: 0;
            }

            .topbar{
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3">

        <div class="text-center mb-4 mt-2">
            <i class="bi bi-mortarboard-fill fs-1 text-warning"></i>
            <h4 class="fw-bold mt-2 mb-0">UniERP</h4>
            <small class="opacity-75">
                University Management System
            </small>
        </div>

        <nav class="nav flex-column gap-1">

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            @role('admin')

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

            @role('admin|teacher')

            <a href="{{ route('attendance.index') }}"
               class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                Attendance
            </a>

            <a href="{{ route('results.index') }}"
               class="nav-link {{ request()->routeIs('results.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i>
                Results
            </a>

            @endrole

        </nav>

        <div class="mt-auto pt-4">

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

        <!-- Topbar -->
        <div class="topbar">

            <h5 class="mb-0 fw-bold">
                <i class="bi bi-speedometer2"></i>
                @yield('title', 'Dashboard')
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
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>
```
