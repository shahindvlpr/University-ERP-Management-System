<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniERP — @yield('title', 'Teacher Portal')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg:     #0f172a;
            --accent:         #059669;
            --accent-light:   #d1fae5;
            --accent-text:    #6ee7b7;
            --sidebar-hover:  rgba(16,185,129,.12);
            --sidebar-active: rgba(16,185,129,.18);
            --border:         #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            overflow-x: hidden;
        }

        /* ── SIDEBAR ── */
        .tp-sidebar {
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
            scrollbar-color: rgba(255,255,255,.1) transparent;
        }
        .tp-sidebar::-webkit-scrollbar { width: 4px; }
        .tp-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.12);
            border-radius: 20px;
        }

        /* Logo */
        .tp-logo {
            padding: 18px 16px 14px;
            border-bottom: 0.5px solid rgba(255,255,255,.07);
            display: flex; align-items: center; gap: 11px;
            flex-shrink: 0;
        }
        .tp-logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #059669, #34d399);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .tp-logo-title { font-size: 14px; font-weight: 600; color: #f8fafc; line-height: 1.2; }
        .tp-logo-sub   { font-size: 10px; color: #475569; }

        /* Nav */
        .tp-nav { padding: 10px 8px; flex: 1; }

        .tp-section {
            font-size: 10px; color: #475569;
            text-transform: uppercase; letter-spacing: 1px;
            padding: 8px 10px 4px; display: block;
        }

        .tp-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            color: #94a3b8; font-size: 13px;
            margin-bottom: 1px;
            text-decoration: none;
            transition: all .2s ease;
            border-left: 3px solid transparent;
        }
        .tp-link i { font-size: 16px; flex-shrink: 0; }
        .tp-link:hover {
            background: var(--sidebar-hover);
            color: #a7f3d0;
            transform: translateX(3px);
        }
        .tp-link.active {
            background: var(--sidebar-active);
            color: var(--accent-text);
            border-left-color: var(--accent);
        }
        .tp-link .tp-badge {
            margin-left: auto;
            font-size: 10px; font-weight: 500;
            padding: 1px 7px; border-radius: 20px;
        }

        .tp-divider { border-color: rgba(255,255,255,.07); margin: 4px 0; }

        /* User panel */
        .tp-user {
            padding: 10px;
            border-top: 0.5px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }
        .tp-user-inner {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 11px; border-radius: 8px;
            background: rgba(255,255,255,.04);
            border: 0.5px solid rgba(255,255,255,.06);
        }
        .tp-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--accent); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; flex-shrink: 0;
        }
        .tp-user-name {
            font-size: 12px; font-weight: 500; color: #f1f5f9;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .tp-user-sub { font-size: 10px; color: #475569; }
        .tp-logout-btn {
            background: none; border: none; padding: 0;
            color: #475569; cursor: pointer; flex-shrink: 0; transition: .2s;
        }
        .tp-logout-btn:hover { color: #ef4444; }

        /* ── MAIN ── */
        .tp-main {
            margin-left: 255px;
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* Topbar */
        .tp-topbar {
            background: #fff;
            padding: 13px 24px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 0.5px solid var(--border);
            position: sticky; top: 0; z-index: 100;
        }
        .tp-page-title { font-size: 15px; font-weight: 600; color: #0f172a; margin: 0; line-height: 1.2; }
        .tp-page-date  { font-size: 11px; color: #94a3b8; margin: 0; }

        .tp-topbar-icon {
            width: 36px; height: 36px; border-radius: 50%;
            background: #f8fafc; border: 0.5px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: #64748b; position: relative;
            text-decoration: none; transition: .2s;
        }
        .tp-topbar-icon:hover { background: #f1f5f9; color: #334155; }
        .tp-topbar-dot {
            position: absolute; top: 5px; right: 5px;
            width: 7px; height: 7px;
            background: #ef4444; border-radius: 50%;
            border: 1.5px solid #fff;
        }
        .tp-role-badge {
            font-size: 11px; font-weight: 500;
            padding: 4px 12px; border-radius: 20px;
            background: var(--accent-light); color: #065f46;
        }
        .tp-topbar-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--accent); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600;
        }

        /* Page body */
        .tp-body { padding: 24px; flex: 1; }

        /* ── SHARED STYLES ── */
        .card {
            border: 0.5px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
            background: #fff;
            transition: box-shadow .2s, transform .2s;
        }
        .card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,.08);
            transform: translateY(-2px);
        }

        .stat-card {
            background: #fff;
            border: 0.5px solid var(--border);
            border-radius: 12px;
            padding: 16px 18px;
            transition: .25s;
        }
        .stat-card:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,.08);
            transform: translateY(-2px);
        }
        .stat-icon  {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .stat-value { font-size: 26px; font-weight: 600; color: #0f172a; line-height: 1.1; }
        .stat-label { font-size: 12px; color: #64748b; margin-bottom: 4px; }
        .stat-change      { font-size: 11px; margin-top: 3px; }
        .stat-change.up   { color: #16a34a; }
        .stat-change.down { color: #dc2626; }
        .stat-change.flat { color: #94a3b8; }

        .table th {
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: .5px;
            color: #64748b; background: #f8fafc;
            border-bottom: 0.5px solid var(--border);
            padding: 10px 14px;
        }
        .table td {
            padding: 11px 14px; font-size: 13px;
            vertical-align: middle;
            border-bottom: 0.5px solid #f1f5f9;
        }
        .table tbody tr:hover { background: #f8fafc; }
        .table tbody tr:last-child td { border-bottom: none; }

        .alert { border: none; border-radius: 10px; font-size: 14px; }

        .btn { border-radius: 8px; font-size: 13px; font-weight: 500; }
        .btn-sm { font-size: 12px; }
        .btn-primary  { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: #047857; border-color: #047857; }

        .form-control, .form-select {
            border: 0.5px solid var(--border);
            border-radius: 8px; font-size: 13px; padding: 8px 12px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(5,150,105,.12);
        }
        .form-label {
            font-size: 12px; font-weight: 600;
            color: #475569; margin-bottom: 5px;
        }
        .badge { font-size: 11px; font-weight: 500; padding: 4px 9px; border-radius: 6px; }

        @media (max-width: 768px) {
            .tp-sidebar { transform: translateX(-100%); transition: .3s; }
            .tp-sidebar.open { transform: translateX(0); }
            .tp-main { margin-left: 0; }
        }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<div class="tp-sidebar">

    <!-- Logo -->
    <div class="tp-logo">
        <div class="tp-logo-icon">👨‍🏫</div>
        <div>
            <div class="tp-logo-title">Teacher Portal</div>
            <div class="tp-logo-sub">Academic Management</div>
        </div>
    </div>

    <!-- Nav -->
    <div class="tp-nav">

        <span class="tp-section">Main</span>

        <a href="{{ route('teacher.dashboard') }}"
           class="tp-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <hr class="tp-divider">
        <span class="tp-section">Academic</span>

        <a href="{{ route('teacher.courses') }}"
           class="tp-link {{ request()->routeIs('teacher.courses') ? 'active' : '' }}">
            <i class="bi bi-book"></i> My Courses
        </a>

        <a href="{{ route('teacher.students') }}"
           class="tp-link {{ request()->routeIs('teacher.students') ? 'active' : '' }}">
            <i class="bi bi-people"></i> My Students
        </a>

        <a href="{{ route('teacher.routine') }}"
           class="tp-link {{ request()->routeIs('teacher.routine') ? 'active' : '' }}">
            <i class="bi bi-calendar-week"></i> Class Routine
        </a>

        <a href="{{ route('teacher.attendance') }}"
           class="tp-link {{ request()->routeIs('teacher.attendance') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Attendance
        </a>

        <a href="{{ route('teacher.results') }}"
           class="tp-link {{ request()->routeIs('teacher.results') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Results
        </a>

        <hr class="tp-divider">
        <span class="tp-section">Info</span>

        <a href="{{ route('teacher.notices') }}"
           class="tp-link {{ request()->routeIs('teacher.notices') ? 'active' : '' }}">
            <i class="bi bi-megaphone"></i> Notices
            @php
                $teacherNoticeCount = \App\Models\Notice::where('is_published', true)
                    ->whereIn('audience', ['all','teachers'])->count();
            @endphp
            @if($teacherNoticeCount > 0)
                <span class="tp-badge" style="background:#f59e0b; color:#fff;">
                    {{ $teacherNoticeCount }}
                </span>
            @endif
        </a>

        <a href="{{ route('teacher.profile') }}"
           class="tp-link {{ request()->routeIs('teacher.profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> My Profile
        </a>

    </div>

    <!-- User + Logout -->
    <div class="tp-user">
        <div class="tp-user-inner">
            <div class="tp-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="flex:1; min-width:0;">
                <div class="tp-user-name">{{ auth()->user()->name }}</div>
                <div class="tp-user-sub">
                    @php
                        $tp = \App\Models\Teacher::where('user_id', auth()->id())->first();
                    @endphp
                    {{ $tp->teacher_id ?? '' }}
                    @if($tp?->designation)
                        · {{ $tp->designation }}
                    @endif
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="tp-logout-btn" title="Logout">
                    <i class="bi bi-box-arrow-right" style="font-size:16px;"></i>
                </button>
            </form>
        </div>
    </div>

</div>

<!-- ── MAIN CONTENT ── -->
<div class="tp-main">

    <!-- Topbar -->
    <div class="tp-topbar">
        <div>
            <p class="tp-page-title">@yield('title', 'Dashboard')</p>
            <p class="tp-page-date">{{ now()->format('l, d F Y') }}</p>
        </div>

        <div class="d-flex align-items-center gap-3">

            <!-- Search -->
            <div class="d-none d-md-flex align-items-center gap-2"
                 style="background:#f8fafc; border:0.5px solid var(--border); border-radius:20px; padding:7px 16px; font-size:12px; color:#94a3b8; min-width:180px;">
                <i class="bi bi-search" style="font-size:12px;"></i>
                <span>Search...</span>
            </div>

            <!-- Bell -->
            <a href="{{ route('teacher.notices') }}" class="tp-topbar-icon">
                <i class="bi bi-bell" style="font-size:15px;"></i>
                @if(($teacherNoticeCount ?? 0) > 0)
                    <span class="tp-topbar-dot"></span>
                @endif
            </a>

            <div style="width:1px; height:22px; background:var(--border);"></div>

            <!-- Role badge -->
            <span class="tp-role-badge">
                <i class="bi bi-person-workspace me-1" style="font-size:11px;"></i>Teacher
            </span>

            <!-- Avatar -->
            <div class="tp-topbar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

        </div>
    </div>

    <!-- Alerts -->
    <div style="padding:16px 24px 0;">
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

    <!-- Page Content -->
    <div class="tp-body">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            bootstrap.Alert.getOrCreateInstance(el)?.close();
        });
    }, 4000);
</script>

@stack('scripts')
</body>
</html>