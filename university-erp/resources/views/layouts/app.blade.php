<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniERP — @yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-hover: rgba(99,102,241,0.12);
            --sidebar-active: rgba(99,102,241,0.18);
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #a5b4fc;
            --accent: #6366f1;
            --accent-light: #ede9fe;
        }

        * { box-sizing: border-box; }

        body {
            background: #f1f5f9;
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
            margin: 0;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 255px;
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.15) transparent;
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 20px; }

        /* Logo area */
        .sidebar-logo {
            padding: 18px 16px 14px;
            border-bottom: 0.5px solid rgba(255,255,255,.07);
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .sidebar-logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .sidebar-logo-text .title {
            font-size: 15px; font-weight: 600;
            color: #f8fafc; line-height: 1.2;
        }

        .sidebar-logo-text .sub {
            font-size: 10px; color: #475569;
        }

        /* Nav */
        .sidebar-nav { padding: 12px 10px; flex: 1; }

        .nav-section-label {
            font-size: 10px;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 10px 5px;
            display: block;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: var(--sidebar-text);
            font-size: 13px;
            margin-bottom: 1px;
            transition: all .2s ease;
            text-decoration: none;
            position: relative;
            border-left: 3px solid transparent;
        }

        .sidebar-nav .nav-link i {
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-nav .nav-link:hover {
            background: var(--sidebar-hover);
            color: #c7d2fe;
            transform: translateX(3px);
        }

        .sidebar-nav .nav-link.active {
            background: var(--sidebar-active);
            color: var(--sidebar-text-active);
            border-left-color: var(--accent);
        }

        .sidebar-nav .nav-link .badge-pill {
            margin-left: auto;
            font-size: 10px;
            padding: 1px 7px;
            border-radius: 20px;
            font-weight: 500;
        }

        .sidebar-divider {
            border-color: rgba(255,255,255,.07);
            margin: 4px 0;
        }

        /* User panel */
        .sidebar-user {
            padding: 10px;
            border-top: 0.5px solid rgba(255,255,255,.07);
        }

        .sidebar-user-inner {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            background: rgba(255,255,255,.04);
            border: 0.5px solid rgba(255,255,255,.06);
        }

        .sidebar-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600;
            flex-shrink: 0;
        }

        .sidebar-user-name {
            font-size: 12px; font-weight: 500;
            color: #f1f5f9;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .sidebar-user-email {
            font-size: 10px; color: #475569;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .sidebar-logout-btn {
            background: none; border: none; padding: 0;
            color: #475569; cursor: pointer; transition: .2s;
            flex-shrink: 0;
        }
        .sidebar-logout-btn:hover { color: #ef4444; }

        /* ── TOPBAR ── */
        .main-content { margin-left: 255px; }

        .topbar {
            background: #fff;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 0.5px solid #e2e8f0;
            position: sticky; top: 0; z-index: 100;
        }

        .topbar-left .page-title {
            font-size: 16px; font-weight: 600;
            color: #0f172a; margin: 0; line-height: 1.2;
        }

        .topbar-left .breadcrumb-text {
            font-size: 11px; color: #94a3b8; margin: 0;
        }

        .topbar-search {
            display: flex; align-items: center; gap: 8px;
            background: #f8fafc;
            border: 0.5px solid #e2e8f0;
            border-radius: 20px;
            padding: 7px 16px;
            font-size: 12px; color: #94a3b8;
            width: 220px;
        }

        .topbar-icon-btn {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #f8fafc;
            border: 0.5px solid #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            color: #64748b; cursor: pointer;
            position: relative; transition: .2s;
            text-decoration: none;
        }
        .topbar-icon-btn:hover { background: #f1f5f9; color: #334155; }

        .topbar-dot {
            position: absolute; top: 5px; right: 5px;
            width: 7px; height: 7px;
            background: #ef4444; border-radius: 50%;
            border: 1.5px solid #fff;
        }

        .topbar-role-badge {
            font-size: 11px; font-weight: 500;
            padding: 4px 12px; border-radius: 20px;
            background: var(--accent-light);
            color: #4338ca;
        }

        .topbar-user-name {
            font-size: 13px; font-weight: 500;
            color: #334155;
        }

        /* ── PAGE CONTENT ── */
        .page-body { padding: 24px; min-height: calc(100vh - 61px); }

        /* ── CARDS ── */
        .card {
            border: 0.5px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
            transition: box-shadow .2s, transform .2s;
            background: #fff;
        }
        .card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,.08);
            transform: translateY(-2px);
        }

        /* ── STAT CARDS ── */
        .stat-card {
            background: #fff;
            border: 0.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 18px;
            transition: .25s;
        }
        .stat-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); transform: translateY(-2px); }

        .stat-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }

        .stat-value { font-size: 26px; font-weight: 600; color: #0f172a; line-height: 1.1; }
        .stat-label { font-size: 12px; color: #64748b; margin-bottom: 4px; }
        .stat-change { font-size: 11px; margin-top: 3px; }
        .stat-change.up   { color: #16a34a; }
        .stat-change.down { color: #dc2626; }
        .stat-change.flat { color: #94a3b8; }

        /* ── ALERTS ── */
        .alert { border: none; border-radius: 10px; font-size: 14px; }

        /* ── TABLES ── */
        .table th {
            font-size: 12px; font-weight: 600;
            text-transform: uppercase; letter-spacing: .5px;
            color: #64748b; background: #f8fafc;
            border-bottom: 0.5px solid #e2e8f0;
            padding: 10px 14px;
        }
        .table td { padding: 11px 14px; font-size: 13px; vertical-align: middle; border-bottom: 0.5px solid #f1f5f9; }
        .table tbody tr:hover { background: #f8fafc; }
        .table tbody tr:last-child td { border-bottom: none; }

        /* ── BUTTONS ── */
        .btn { border-radius: 8px; font-size: 13px; font-weight: 500; }
        .btn-sm { font-size: 12px; }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: #4f46e5; border-color: #4f46e5; }

        /* ── FORM CONTROLS ── */
        .form-control, .form-select {
            border: 0.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            padding: 8px 12px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        }
        .form-label { font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 5px; }

        /* ── BADGES ── */
        .badge { font-size: 11px; font-weight: 500; padding: 4px 9px; border-radius: 6px; }

        /* ── MOBILE ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: .3s; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<div class="sidebar">

    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">🎓</div>
        <div class="sidebar-logo-text">
            <div class="title">UniERP</div>
            <div class="sub">University Management</div>
        </div>
    </div>

    <div class="sidebar-nav">

        <span class="nav-section-label">Main</span>

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        @role('admin')

        <hr class="sidebar-divider">
        <span class="nav-section-label">Academic</span>

        <a href="{{ route('departments.index') }}"
           class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> Departments
        </a>

        <a href="{{ route('students.index') }}"
           class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Students
        </a>

        <a href="{{ route('teachers.index') }}"
           class="nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
            <i class="bi bi-person-workspace"></i> Teachers
        </a>

        <a href="{{ route('courses.index') }}"
           class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Courses
        </a>

        <hr class="sidebar-divider">
        <span class="nav-section-label">Management</span>

        <a href="{{ route('fees.index') }}"
           class="nav-link {{ request()->routeIs('fees.*') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i> Fees
        </a>

        <a href="{{ route('notices.index') }}"
           class="nav-link {{ request()->routeIs('notices.*') ? 'active' : '' }}">
            <i class="bi bi-megaphone"></i> Notices
            @php $unread = \App\Models\Notice::where('is_published',true)->count(); @endphp
            @if($unread > 0)
                <span class="badge-pill bg-warning text-dark">{{ $unread }}</span>
            @endif
        </a>

        <a href="{{ route('reports.index') }}"
           class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i> Reports
        </a>

        @endrole

        <hr class="sidebar-divider">
        <span class="nav-section-label">Examination</span>

        @role('admin|teacher')

        <a href="{{ route('attendance.index') }}"
           class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Attendance
        </a>

        <a href="{{ route('enrollments.index') }}"
           class="nav-link {{ request()->routeIs('enrollments.*') ? 'active' : '' }}">
            <i class="bi bi-journal-check"></i> Enrollments
        </a>

        <a href="{{ route('results.index') }}"
           class="nav-link {{ request()->routeIs('results.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Results
        </a>

        <a href="{{ route('routines.index') }}"
           class="nav-link {{ request()->routeIs('routines.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-week"></i> Routine
        </a>

        <hr class="sidebar-divider">
        <span class="nav-section-label">Library</span>

        <a href="{{ route('books.index') }}"
           class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
            <i class="bi bi-book-half"></i> Library Books
        </a>

        <a href="{{ route('book-issues.index') }}"
           class="nav-link {{ request()->routeIs('book-issues.*') ? 'active' : '' }}">
            <i class="bi bi-journal-check"></i> Book Issues
        </a>

        <hr class="sidebar-divider">
        <span class="nav-section-label">Exam & Certificates</span>

        <a href="{{ route('exams.index') }}"
           class="nav-link {{ request()->routeIs('exams.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Exams
        </a>

        <a href="{{ route('exam-marks.index') }}"
           class="nav-link {{ request()->routeIs('exam-marks.*') ? 'active' : '' }}">
            <i class="bi bi-pencil-square"></i> Exam Marks
        </a>

        <a href="{{ route('transcripts.index') }}"
           class="nav-link {{ request()->routeIs('transcripts.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Transcripts
        </a>

        <a href="{{ route('certificates.index') }}"
           class="nav-link {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
            <i class="bi bi-patch-check-fill"></i> Certificates
        </a>

        <hr class="sidebar-divider">
        <span class="nav-section-label">Portals</span>

        <a href="{{ route('student.dashboard') }}"
           class="nav-link {{ request()->routeIs('student.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Student Portal
        </a>
@hasanyrole('admin|teacher')
<a href="{{ route('teacher.dashboard') }}"
   class="nav-link {{ request()->routeIs('teacher.*') ? 'active' : '' }}">
    <i class="bi bi-person-workspace"></i> Teacher Portal
</a>
@endhasanyrole
        @endrole

    </div>

    <!-- User + Logout -->
    <div class="sidebar-user">
        <div class="sidebar-user-inner">
            <div class="sidebar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="flex:1;min-width:0">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-email">{{ auth()->user()->email }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout-btn" title="Logout">
                    <i class="bi bi-box-arrow-right" style="font-size:16px"></i>
                </button>
            </form>
        </div>
    </div>

</div>

<!-- ── MAIN CONTENT ── -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-left">
            <p class="page-title">@yield('title', 'Dashboard')</p>
            <p class="breadcrumb-text">
                Welcome back, <strong>{{ auth()->user()->name }}</strong> &mdash; {{ now()->format('l, d M Y') }}
            </p>
        </div>

        <div class="d-flex align-items-center gap-3">

            <!-- Search -->
            <div class="topbar-search d-none d-md-flex">
                <i class="bi bi-search" style="font-size:13px"></i>
                <span>Quick search...</span>
            </div>

            <!-- Notification Bell -->
            <a href="{{ route('notices.index') }}" class="topbar-icon-btn">
                <i class="bi bi-bell" style="font-size:16px"></i>
                <span class="topbar-dot"></span>
            </a>

            <!-- Divider -->
            <div style="width:1px;height:24px;background:#e2e8f0"></div>

            <!-- Role badge -->
            <span class="topbar-role-badge">
                <i class="bi bi-shield-check me-1" style="font-size:11px"></i>
                {{ ucfirst(auth()->user()->getRoleNames()->first()) }}
            </span>

            <!-- Avatar + Name -->
            <div class="d-flex align-items-center gap-2">
                <div style="width:34px;height:34px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:600">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="topbar-user-name d-none d-md-block">{{ auth()->user()->name }}</span>
            </div>

        </div>
    </div>

    <!-- Alerts -->
    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill text-success"></i>
                {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-circle-fill text-danger"></i>
                {{ session('error') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Page Body -->
    <div class="page-body">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Auto-hide alerts after 4 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            let bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            bsAlert.close();
        });
    }, 4000);
</script>

@stack('scripts')
</body>
</html>