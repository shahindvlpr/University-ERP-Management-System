@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- ── WELCOME BANNER ── --}}
<div style="background:#0f172a; border-radius:16px; padding:24px 28px; margin-bottom:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
    <div>
        <h2 style="color:#f8fafc; font-size:20px; font-weight:600; margin:0 0 5px;">
            Welcome back, {{ auth()->user()->name }} 👋
        </h2>
        <p style="color:#64748b; font-size:13px; margin:0;">
            University ERP Management System &nbsp;·&nbsp; {{ now()->format('l, d F Y') }}
        </p>
    </div>
    <div style="display:flex; gap:12px;">
        <div style="background:rgba(255,255,255,.06); border:0.5px solid rgba(255,255,255,.1); border-radius:10px; padding:10px 20px; text-align:center;">
            <div style="color:#a5b4fc; font-size:22px; font-weight:600; line-height:1;">{{ $stats['students'] }}</div>
            <div style="color:#475569; font-size:10px; margin-top:2px;">Students</div>
        </div>
        <div style="background:rgba(255,255,255,.06); border:0.5px solid rgba(255,255,255,.1); border-radius:10px; padding:10px 20px; text-align:center;">
            <div style="color:#6ee7b7; font-size:22px; font-weight:600; line-height:1;">{{ $stats['teachers'] }}</div>
            <div style="color:#475569; font-size:10px; margin-top:2px;">Teachers</div>
        </div>
        <div style="background:rgba(255,255,255,.06); border:0.5px solid rgba(255,255,255,.1); border-radius:10px; padding:10px 20px; text-align:center;">
            <div style="color:#fcd34d; font-size:22px; font-weight:600; line-height:1;">{{ $stats['courses'] }}</div>
            <div style="color:#475569; font-size:10px; margin-top:2px;">Courses</div>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#ede9fe;">
                <i class="bi bi-people-fill" style="color:#6366f1; font-size:18px;"></i>
            </div>
            <div class="stat-value">{{ $stats['students'] }}</div>
            <div class="stat-label">Total Students</div>
            <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> 12 this month</div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#d1fae5;">
                <i class="bi bi-person-workspace" style="color:#059669; font-size:18px;"></i>
            </div>
            <div class="stat-value">{{ $stats['teachers'] }}</div>
            <div class="stat-label">Total Teachers</div>
            <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> 2 this month</div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7;">
                <i class="bi bi-book-fill" style="color:#d97706; font-size:18px;"></i>
            </div>
            <div class="stat-value">{{ $stats['courses'] }}</div>
            <div class="stat-label">Active Courses</div>
            <div class="stat-change flat"><i class="bi bi-dash"></i> No change</div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fee2e2;">
                <i class="bi bi-cash-stack" style="color:#ef4444; font-size:18px;"></i>
            </div>
            <div class="stat-value" style="font-size:18px;">৳{{ number_format($stats['fee_due']) }}</div>
            <div class="stat-label">Fee Due</div>
            <div class="stat-change down"><i class="bi bi-arrow-down-short"></i> 3 unpaid</div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dbeafe;">
                <i class="bi bi-bar-chart-line-fill" style="color:#3b82f6; font-size:18px;"></i>
            </div>
            <div class="stat-value">{{ $stats['results'] }}</div>
            <div class="stat-label">Total Results</div>
            <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> 24 new</div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#d1fae5;">
                <i class="bi bi-journal-check" style="color:#059669; font-size:18px;"></i>
            </div>
            <div class="stat-value">{{ $stats['enrollments'] }}</div>
            <div class="stat-label">Enrollments</div>
            <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> 8 new</div>
        </div>
    </div>

</div>

{{-- ── QUICK ACTIONS ── --}}
<div class="card p-4 mb-4">
    <h6 class="fw-semibold mb-3" style="color:#0f172a;">
        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>Quick Actions
    </h6>
    <div class="row g-2">
        <div class="col-6 col-md-3">
            <a href="{{ route('students.create') }}"
               class="d-flex align-items-center gap-2 p-3 rounded-3 text-decoration-none"
               style="background:#ede9fe; border:0.5px solid #c4b5fd; color:#4338ca; transition:.2s;"
               onmouseover="this.style.background='#ddd6fe'" onmouseout="this.style.background='#ede9fe'">
                <i class="bi bi-person-plus-fill fs-5"></i>
                <span class="fw-semibold small">Add Student</span>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('teachers.create') }}"
               class="d-flex align-items-center gap-2 p-3 rounded-3 text-decoration-none"
               style="background:#d1fae5; border:0.5px solid #6ee7b7; color:#065f46; transition:.2s;"
               onmouseover="this.style.background='#a7f3d0'" onmouseout="this.style.background='#d1fae5'">
                <i class="bi bi-person-workspace fs-5"></i>
                <span class="fw-semibold small">Add Teacher</span>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('courses.create') }}"
               class="d-flex align-items-center gap-2 p-3 rounded-3 text-decoration-none"
               style="background:#fef3c7; border:0.5px solid #fcd34d; color:#92400e; transition:.2s;"
               onmouseover="this.style.background='#fde68a'" onmouseout="this.style.background='#fef3c7'">
                <i class="bi bi-book-fill fs-5"></i>
                <span class="fw-semibold small">Add Course</span>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('results.create') }}"
               class="d-flex align-items-center gap-2 p-3 rounded-3 text-decoration-none"
               style="background:#fee2e2; border:0.5px solid #fca5a5; color:#991b1b; transition:.2s;"
               onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                <i class="bi bi-bar-chart-fill fs-5"></i>
                <span class="fw-semibold small">Add Result</span>
            </a>
        </div>
    </div>
</div>

{{-- ── MIDDLE ROW: Attendance + Notices + Grade Overview ── --}}
<div class="row g-4 mb-4">

    {{-- Attendance --}}
    <div class="col-lg-4">
        <div class="card p-4 h-100">
            <h6 class="fw-semibold mb-3" style="color:#0f172a;">
                <i class="bi bi-calendar-check me-2 text-primary"></i>Today's Attendance
            </h6>
            <div class="row g-2 mb-3">
                <div class="col-4">
                    <div class="text-center p-3 rounded-3" style="background:#f0fdf4;">
                        <div style="font-size:24px; font-weight:600; color:#16a34a;">{{ $stats['today_present'] }}</div>
                        <div style="font-size:11px; color:#64748b;">Present</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center p-3 rounded-3" style="background:#fef2f2;">
                        <div style="font-size:24px; font-weight:600; color:#dc2626;">{{ $stats['today_absent'] }}</div>
                        <div style="font-size:11px; color:#64748b;">Absent</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center p-3 rounded-3" style="background:#fffbeb;">
                        <div style="font-size:24px; font-weight:600; color:#d97706;">
                            {{ $stats['today_late'] ?? 0 }}
                        </div>
                        <div style="font-size:11px; color:#64748b;">Late</div>
                    </div>
                </div>
            </div>
            @php
                $total = ($stats['today_present'] + $stats['today_absent'] + ($stats['today_late'] ?? 0));
                $rate  = $total > 0 ? round(($stats['today_present'] / $total) * 100) : 0;
            @endphp
            <div class="mb-2">
                <div class="d-flex justify-content-between mb-1">
                    <span style="font-size:12px; color:#64748b;">Attendance rate</span>
                    <span style="font-size:12px; font-weight:600; color:#0f172a;">{{ $rate }}%</span>
                </div>
                <div style="height:6px; background:#f1f5f9; border-radius:10px; overflow:hidden;">
                    <div style="width:{{ $rate }}%; height:100%; background:#6366f1; border-radius:10px; transition:.6s ease;"></div>
                </div>
            </div>
            <div>
                <div class="d-flex justify-content-between mb-1">
                    <span style="font-size:12px; color:#64748b;">Present</span>
                    <span style="font-size:12px; font-weight:600; color:#0f172a;">{{ $rate }}%</span>
                </div>
                <div style="height:6px; background:#f1f5f9; border-radius:10px; overflow:hidden;">
                    <div style="width:{{ $rate }}%; height:100%; background:#22c55e; border-radius:10px; transition:.6s ease;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Notices --}}
    <div class="col-lg-4">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold mb-0" style="color:#0f172a;">
                    <i class="bi bi-megaphone me-2 text-warning"></i>Recent Notices
                </h6>
                <a href="{{ route('notices.index') }}" style="font-size:12px; color:#6366f1; text-decoration:none;">View all</a>
            </div>
            @forelse($recent_notices as $notice)
            <div class="d-flex align-items-start gap-2 pb-2 mb-2" style="border-bottom:0.5px solid #f1f5f9;">
                @php
                    $cat = $notice->category;
                    $badge = match($cat) {
                        'exam'    => ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'Exam'],
                        'event'   => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'Event'],
                        'holiday' => ['bg'=>'#fef3c7','color'=>'#92400e','label'=>'Holiday'],
                        default   => ['bg'=>'#dbeafe','color'=>'#1d4ed8','label'=>'General'],
                    };
                @endphp
                <span style="background:{{ $badge['bg'] }}; color:{{ $badge['color'] }}; font-size:10px; padding:2px 8px; border-radius:20px; white-space:nowrap; margin-top:2px;">
                    {{ $badge['label'] }}
                </span>
                <div>
                    <div style="font-size:12px; font-weight:500; color:#0f172a; line-height:1.3;">{{ $notice->title }}</div>
                    <div style="font-size:10px; color:#94a3b8; margin-top:2px;">
                        {{ \Carbon\Carbon::parse($notice->publish_date)->format('d M Y') }}
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-3">
                <i class="bi bi-bell-slash" style="font-size:28px; color:#cbd5e1;"></i>
                <p style="font-size:13px; color:#94a3b8; margin-top:8px; margin-bottom:0;">No notices available</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Grade Overview --}}
    <div class="col-lg-4">
        <div class="card p-4 h-100">
            <h6 class="fw-semibold mb-3" style="color:#0f172a;">
                <i class="bi bi-graph-up me-2" style="color:#6366f1;"></i>Grade Overview
            </h6>
            @php
                $grades = [
                    ['label'=>'A+ Grades','pct'=>34,'color'=>'#6366f1'],
                    ['label'=>'A Grades', 'pct'=>28,'color'=>'#22c55e'],
                    ['label'=>'B+ Grades','pct'=>18,'color'=>'#f59e0b'],
                    ['label'=>'B & Below','pct'=>20,'color'=>'#ef4444'],
                ];
            @endphp
            @foreach($grades as $g)
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span style="font-size:12px; color:#64748b;">{{ $g['label'] }}</span>
                    <span style="font-size:12px; font-weight:600; color:#0f172a;">{{ $g['pct'] }}%</span>
                </div>
                <div style="height:6px; background:#f1f5f9; border-radius:10px; overflow:hidden;">
                    <div style="width:{{ $g['pct'] }}%; height:100%; background:{{ $g['color'] }}; border-radius:10px; transition:.6s ease;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ── RECENT RESULTS TABLE ── --}}
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-semibold mb-0" style="color:#0f172a;">
            <i class="bi bi-trophy me-2 text-warning"></i>Recent Results
        </h6>
        <a href="{{ route('results.index') }}" class="btn btn-sm" style="background:#ede9fe; color:#4338ca; border:0.5px solid #c4b5fd; font-size:12px;">
            View All <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Total Marks</th>
                    <th>Grade</th>
                    <th>GPA</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_results as $result)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:30px; height:30px; border-radius:50%; background:#ede9fe; color:#4338ca; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:600;">
                                {{ strtoupper(substr($result->student->name ?? 'S', 0, 1)) }}
                            </div>
                            <span style="font-size:13px;">{{ $result->student->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td style="font-size:13px;">{{ $result->course->name ?? '-' }}</td>
                    <td>
                        <span style="font-size:13px; font-weight:600; color:#0f172a;">{{ $result->total_marks }}</span>
                        <span style="font-size:11px; color:#94a3b8;">/100</span>
                    </td>
                    <td>
                        @php
                            $gc = match(true) {
                                $result->grade == 'A+' => ['bg'=>'#d1fae5','c'=>'#065f46'],
                                $result->grade == 'A'  => ['bg'=>'#d1fae5','c'=>'#065f46'],
                                str_starts_with($result->grade ?? '', 'B') => ['bg'=>'#fef3c7','c'=>'#92400e'],
                                default => ['bg'=>'#fee2e2','c'=>'#991b1b'],
                            };
                        @endphp
                        <span style="background:{{ $gc['bg'] }}; color:{{ $gc['c'] }}; font-size:11px; font-weight:500; padding:3px 10px; border-radius:20px;">
                            {{ $result->grade }}
                        </span>
                    </td>
                    <td>
                        <span style="background:#dbeafe; color:#1e40af; font-size:11px; font-weight:500; padding:3px 10px; border-radius:20px;">
                            {{ $result->gpa }}
                        </span>
                    </td>
                    <td>
                        <span style="background:#f0fdf4; color:#15803d; font-size:11px; padding:3px 10px; border-radius:20px;">
                            Passed
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="bi bi-inbox" style="font-size:32px; color:#cbd5e1;"></i>
                        <p style="color:#94a3b8; font-size:13px; margin-top:8px; margin-bottom:0;">No results available</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection