<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniERP — @yield('title', 'Student Portal')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg:     #0f172a;
            --accent:         #6366f1;
            --accent-light:   #ede9fe;
            --accent-text:    #a5b4fc;
            --sidebar-hover:  rgba(99,102,241,.12);
            --sidebar-active: rgba(99,102,241,.18);
            --border:         #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            overflow-x: hidden;
        }

        /* ── SIDEBAR ── */
        .sp-sidebar {
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
        .sp-sidebar::-webkit-scrollbar { width: 4px; }
        .sp-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 20px; }

        /* Logo */
        .sp-logo {
            padding: 18px 16px 14px;
            border-bottom: 0.5px solid rgba(255,255,255,.07);
            display: flex;
            align-items: center;
            gap: 11px;
            flex-shrink: 0;
        }
        .sp-logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .sp-logo-title { font-size: 14px; font-weight: 600; color: #f8fafc; line-height: 1.2; }
        .sp-logo-sub   { font-size: 10px; color: #475569; }

        /* Nav */
        .sp-nav { padding: 10px 8px; flex: 1; }

        .sp-section {
            font-size: 10px; color: #475569;
            text-transform: uppercase; letter-spacing: 1px;
            padding: 8px 10px 4px; display: block;
        }

        .sp-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            color: #94a3b8; font-size: 13px;
            margin-bottom: 1px;
            text-decoration: none;
            transition: all .2s ease;
            border-left: 3px solid transparent;
            position: relative;
        }
        .sp-link i { font-size: 16px; flex-shrink: 0; }
        .sp-link:hover {
            background: var(--sidebar-hover);
            color: #c7d2fe;
            transform: translateX(3px);
        }
        .sp-link.active {
            background: var(--sidebar-active);
            color: var(--accent-text);
            border-left-color: var(--accent);
        }
        .sp-link .sp-badge {
            margin-left: auto;
            font-size: 10px; font-weight: 500;
            padding: 1px 7px; border-radius: 20px;
        }

        .sp-divider { border-color: rgba(255,255,255,.07); margin: 4px 0; }

        /* User panel */
        .sp-user {
            padding: 10px;
            border-top: 0.5px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }
        .sp-user-inner {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 11px; border-radius: 8px;
            background: rgba(255,255,255,.04);
            border: 0.5px solid rgba(255,255,255,.06);
        }
        .sp-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--accent); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; flex-shrink: 0;
        }
        .sp-user-name  { font-size: 12px; font-weight: 500; color: #f1f5f9; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sp-user-sub   { font-size: 10px; color: #475569; }
        .sp-logout-btn {
            background: none; border: none; padding: 0;
            color: #475569; cursor: pointer; flex-shrink: 0; transition: .2s;
        }
        .sp-logout-btn:hover { color: #ef4444; }

        /* ── MAIN CONTENT ── */
        .sp-main { margin-left: 255px; min-height: 100vh; display: flex; flex-direction: column; }

        /* Topbar */
        .sp-topbar {
            background: #fff;
            padding: 13px 24px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 0.5px solid var(--border);
            position: sticky; top: 0; z-index: 100;
        }
        .sp-page-title { font-size: 15px; font-weight: 600; color: #0f172a; margin: 0; line-height: 1.2; }
        .sp-page-date  { font-size: 11px; color: #94a3b8; margin: 0; }

        .sp-topbar-icon {
            width: 36px; height: 36px; border-radius: 50%;
            background: #f8fafc; border: 0.5px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: #64748b; position: relative; text-decoration: none; transition: .2s;
        }
        .sp-topbar-icon:hover { background: #f1f5f9; color: #334155; }
        .sp-topbar-dot {
            position: absolute; top: 5px; right: 5px;
            width: 7px; height: 7px;
            background: #ef4444; border-radius: 50%;
            border: 1.5px solid #fff;
        }
        .sp-role-badge {
            font-size: 11px; font-weight: 500;
            padding: 4px 12px; border-radius: 20px;
            background: var(--accent-light); color: #4338ca;
        }
        .sp-topbar-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--accent); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600;
        }

        /* Page body */
        .sp-body { padding: 24px; flex: 1; }

        /* ── CARDS (shared styles for child views) ── */
        .card {
            border: 0.5px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
            background: #fff;
            transition: box-shadow .2s, transform .2s;
        }
        .card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); transform: translateY(-2px); }

        .stat-card {
            background: #fff;
            border: 0.5px solid var(--border);
            border-radius: 12px;
            padding: 16px 18px;
            transition: .25s;
        }
        .stat-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
        .stat-icon  { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .stat-value { font-size: 26px; font-weight: 600; color: #0f172a; line-height: 1.1; }
        .stat-label { font-size: 12px; color: #64748b; margin-bottom: 4px; }
        .stat-change      { font-size: 11px; margin-top: 3px; }
        .stat-change.up   { color: #16a34a; }
        .stat-change.down { color: #dc2626; }
        .stat-change.flat { color: #94a3b8; }

        /* Table */
        .table th {
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: .5px;
            color: #64748b; background: #f8fafc;
            border-bottom: 0.5px solid var(--border);
            padding: 10px 14px;
        }
        .table td { padding: 11px 14px; font-size: 13px; vertical-align: middle; border-bottom: 0.5px solid #f1f5f9; }
        .table tbody tr:hover { background: #f8fafc; }
        .table tbody tr:last-child td { border-bottom: none; }

        /* Alerts */
        .alert { border: none; border-radius: 10px; font-size: 14px; }

        /* Buttons */
        .btn { border-radius: 8px; font-size: 13px; font-weight: 500; }
        .btn-sm { font-size: 12px; }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: #4f46e5; border-color: #4f46e5; }

        /* Forms */
        .form-control, .form-select {
            border: 0.5px solid var(--border); border-radius: 8px;
            font-size: 13px; padding: 8px 12px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        }
        .form-label { font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 5px; }

        /* Badges */
        .badge { font-size: 11px; font-weight: 500; padding: 4px 9px; border-radius: 6px; }

        /* Mobile */
        @media (max-width: 768px) {
            .sp-sidebar { transform: translateX(-100%); transition: .3s; }
            .sp-sidebar.open { transform: translateX(0); }
            .sp-main { margin-left: 0; }
            .sp-topbar { flex-wrap: wrap; gap: 10px; }
        }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<div class="sp-sidebar">

    <!-- Logo -->
    <div class="sp-logo">
        <div class="sp-logo-icon">🎓</div>
        <div>
            <div class="sp-logo-title">Student Portal</div>
            <div class="sp-logo-sub">Academic Management</div>
        </div>
    </div>

    <!-- Nav -->
    <div class="sp-nav">

        <span class="sp-section">Main</span>

        <a href="{{ route('student.dashboard') }}"
           class="sp-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <hr class="sp-divider">
        <span class="sp-section">Academic</span>

        <a href="{{ route('student.courses') }}"
           class="sp-link {{ request()->routeIs('student.courses') ? 'active' : '' }}">
            <i class="bi bi-book"></i> My Courses
        </a>

        <a href="{{ route('student.attendance') }}"
           class="sp-link {{ request()->routeIs('student.attendance') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Attendance
        </a>

        <a href="{{ route('student.results') }}"
           class="sp-link {{ request()->routeIs('student.results') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Results
        </a>

        <a href="{{ route('student.transcript') }}"
           class="sp-link {{ request()->routeIs('student.transcript') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Transcript
        </a>

        <hr class="sp-divider">
        <span class="sp-section">Finance</span>

        <a href="{{ route('student.fees') }}"
           class="sp-link {{ request()->routeIs('student.fees') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i> Fee Status
            @php
                $studentFee = \App\Models\FeeInvoice::where('student_id',
                    optional(\App\Models\Student::where('user_id', auth()->id())->first())->id
                )->where('status','unpaid')->count();
            @endphp
            @if($studentFee > 0)
                <span class="sp-badge" style="background:#ef4444; color:#fff;">{{ $studentFee }}</span>
            @endif
        </a>

        <hr class="sp-divider">
        <span class="sp-section">Info</span>

        <a href="{{ route('student.notices') }}"
           class="sp-link {{ request()->routeIs('student.notices') ? 'active' : '' }}">
            <i class="bi bi-megaphone"></i> Notices
            @php
                $noticeCount = \App\Models\Notice::where('is_published', true)
                    ->whereIn('audience', ['all','students'])->count();
            @endphp
            @if($noticeCount > 0)
                <span class="sp-badge" style="background:#f59e0b; color:#fff;">{{ $noticeCount }}</span>
            @endif
        </a>

    </div>

    <!-- User panel + Logout -->
    <div class="sp-user">
        <div class="sp-user-inner">
            <div class="sp-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="flex:1; min-width:0;">
                <div class="sp-user-name">{{ auth()->user()->name }}</div>
                <div class="sp-user-sub">
                    @php $sp = \App\Models\Student::where('user_id', auth()->id())->first(); @endphp
                    {{ $sp->student_id ?? '' }} · {{ $sp->department->name ?? 'Student' }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sp-logout-btn" title="Logout">
                    <i class="bi bi-box-arrow-right" style="font-size:16px;"></i>
                </button>
            </form>
        </div>
    </div>

</div>

<!-- ── MAIN CONTENT ── -->
<div class="sp-main">

    <!-- Topbar -->
    <div class="sp-topbar">
        <div>
            <p class="sp-page-title">@yield('title', 'Dashboard')</p>
            <p class="sp-page-date">{{ now()->format('l, d F Y') }}</p>
        </div>

        <div class="d-flex align-items-center gap-3">

            <!-- Search -->
            <div class="d-none d-md-flex align-items-center gap-2"
                 style="background:#f8fafc; border:0.5px solid var(--border); border-radius:20px; padding:7px 16px; font-size:12px; color:#94a3b8; min-width:180px;">
                <i class="bi bi-search" style="font-size:12px;"></i>
                <span>Search...</span>
            </div>

            <!-- Bell -->
            <a href="{{ route('student.notices') }}" class="sp-topbar-icon">
                <i class="bi bi-bell" style="font-size:15px;"></i>
                @if(($noticeCount ?? 0) > 0)
                    <span class="sp-topbar-dot"></span>
                @endif
            </a>

            <div style="width:1px; height:22px; background:var(--border);"></div>

            <!-- Role badge -->
            <span class="sp-role-badge">
                <i class="bi bi-mortarboard me-1" style="font-size:11px;"></i> Student
            </span>

            <!-- Avatar -->
            <div class="sp-topbar-avatar">
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
    <div class="sp-body">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-hide alerts after 4s
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            bootstrap.Alert.getOrCreateInstance(el)?.close();
        });
    }, 4000);
</script>

@stack('scripts')
</body>
</html>