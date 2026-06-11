@extends('layouts.app')
@section('title', 'Student Portal')

@section('content')

{{-- ── WELCOME BANNER ── --}}
<div style="background:#0f172a; border-radius:16px; padding:24px 28px; margin-bottom:22px; position:relative; overflow:hidden;">

    {{-- Decorative circles --}}
    <div style="position:absolute; right:-40px; top:-40px; width:200px; height:200px; border-radius:50%; background:rgba(99,102,241,.12); pointer-events:none;"></div>
    <div style="position:absolute; right:60px; top:30px; width:110px; height:110px; border-radius:50%; background:rgba(99,102,241,.08); pointer-events:none;"></div>

    <div style="position:relative; z-index:1;">
        <h2 style="color:#f8fafc; font-size:20px; font-weight:600; margin:0 0 4px;">
            Welcome back, {{ $student->name }} 👋
        </h2>
        <p style="color:#64748b; font-size:13px; margin:0 0 14px;">
            Student Portal — Manage your academic journey
        </p>
        <div style="display:flex; flex-wrap:wrap; gap:8px;">
            <span style="background:rgba(255,255,255,.07); border:0.5px solid rgba(255,255,255,.12); border-radius:20px; padding:4px 14px; font-size:11px; color:#a5b4fc;">
                📚 {{ $student->department->name ?? 'N/A' }}
            </span>
            <span style="background:rgba(255,255,255,.07); border:0.5px solid rgba(255,255,255,.12); border-radius:20px; padding:4px 14px; font-size:11px; color:#a5b4fc;">
                🎓 Session {{ $student->session }}
            </span>
            <span style="background:rgba(255,255,255,.07); border:0.5px solid rgba(255,255,255,.12); border-radius:20px; padding:4px 14px; font-size:11px; color:#a5b4fc;">
                📋 Semester {{ $student->semester }}
            </span>
            <span style="background:rgba(255,255,255,.07); border:0.5px solid rgba(255,255,255,.12); border-radius:20px; padding:4px 14px; font-size:11px; color:#a5b4fc;">
                🆔 {{ $student->student_id }}
            </span>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#ede9fe;">
                <i class="bi bi-book-fill" style="color:#6366f1; font-size:18px;"></i>
            </div>
            <div class="stat-value">{{ $courseCount }}</div>
            <div class="stat-label">Enrolled Courses</div>
            <div class="stat-change flat" style="color:#6366f1;">Active semester</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#d1fae5;">
                <i class="bi bi-calendar-check-fill" style="color:#059669; font-size:18px;"></i>
            </div>
            <div class="stat-value">{{ $attendanceRate ?? $attendanceCount }}<span style="font-size:14px; color:#64748b;">%</span></div>
            <div class="stat-label">Attendance Rate</div>
            <div class="stat-change up">↑ Good standing</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7;">
                <i class="bi bi-bar-chart-fill" style="color:#d97706; font-size:18px;"></i>
            </div>
            <div class="stat-value">{{ number_format($cgpa ?? 0, 2) }}</div>
            <div class="stat-label">Current CGPA</div>
            <div class="stat-change flat" style="color:#d97706;">
                {{ ($cgpa ?? 0) >= 3.75 ? 'Distinction' : (($cgpa ?? 0) >= 3.0 ? 'First Class' : 'Pass') }}
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fee2e2;">
                <i class="bi bi-cash-stack" style="color:#ef4444; font-size:18px;"></i>
            </div>
            <div class="stat-value" style="font-size:18px;">৳{{ number_format($feeDue) }}</div>
            <div class="stat-label">Fee Due</div>
            <div class="stat-change down">↓ Pay now</div>
        </div>
    </div>

</div>

{{-- ── MAIN GRID ── --}}
<div class="row g-4">

    {{-- ── LEFT COLUMN ── --}}
    <div class="col-lg-4">

        {{-- Profile Card --}}
        <div class="card p-4 mb-4">
            <div class="text-center mb-3">
                <div style="width:80px; height:80px; border-radius:50%; background:#6366f1; color:#fff; display:flex; align-items:center; justify-content:center; font-size:30px; font-weight:600; margin:0 auto 10px;">
                    {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>
                <h5 style="font-size:16px; font-weight:600; color:#0f172a; margin:0 0 3px;">
                    {{ $student->name }}
                </h5>
                <div style="font-size:12px; color:#6366f1; margin-bottom:6px;">
                    {{ $student->student_id }}
                </div>
                <span style="background:#d1fae5; color:#065f46; font-size:11px; padding:3px 12px; border-radius:20px; font-weight:500;">
                    <i class="bi bi-circle-fill me-1" style="font-size:7px;"></i>
                    {{ ucfirst($student->status) }}
                </span>
            </div>
            <hr style="border-color:#f1f5f9; margin:12px 0;">
            <div>
                @foreach([
                    ['label'=>'Department', 'value'=> $student->department->name ?? '-', 'icon'=>'bi-building'],
                    ['label'=>'Session',    'value'=> $student->session,                  'icon'=>'bi-calendar'],
                    ['label'=>'Semester',   'value'=> $student->semester . 'th',          'icon'=>'bi-layers'],
                    ['label'=>'Gender',     'value'=> ucfirst($student->gender ?? '-'),   'icon'=>'bi-person'],
                    ['label'=>'Phone',      'value'=> $student->phone ?? '-',             'icon'=>'bi-telephone'],
                    ['label'=>'Email',      'value'=> $student->email,                    'icon'=>'bi-envelope'],
                ] as $info)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:7px 0; border-bottom:0.5px solid #f8fafc;">
                    <span style="font-size:12px; color:#64748b; display:flex; align-items:center; gap:6px;">
                        <i class="bi {{ $info['icon'] }}" style="font-size:13px;"></i>
                        {{ $info['label'] }}
                    </span>
                    <span style="font-size:12px; font-weight:500; color:#0f172a; text-align:right; max-width:55%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ $info['value'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Semester Progress --}}
        <div class="card p-4">
            <h6 class="fw-semibold mb-3" style="color:#0f172a; font-size:13px;">
                <i class="bi bi-graph-up me-2" style="color:#6366f1;"></i>Semester Progress
            </h6>
            @php
                $totalAtt = $attendanceCount > 0 ? $attendanceCount : 1;
                $attRate  = $attendanceRate ?? min(round(($attendanceCount / max($totalAtt,1)) * 100), 100);
                $feeTotal = $feeDue + ($feePaid ?? 0);
                $feeRate  = $feeTotal > 0 ? round((($feePaid ?? 0) / $feeTotal) * 100) : 0;
            @endphp
            @foreach([
                ['label'=>'Attendance',  'pct'=> $attRate,            'color'=>'#6366f1'],
                ['label'=>'CGPA (/4.0)', 'pct'=> round(($cgpa ?? 0) / 4 * 100), 'color'=>'#22c55e'],
                ['label'=>'Fee Paid',    'pct'=> $feeRate,            'color'=>'#f59e0b'],
            ] as $p)
            <div class="mb-3">
                <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px;">
                    <span style="color:#64748b;">{{ $p['label'] }}</span>
                    <span style="font-weight:600; color:#0f172a;">{{ $p['pct'] }}%</span>
                </div>
                <div style="height:6px; background:#f1f5f9; border-radius:10px; overflow:hidden;">
                    <div style="width:{{ $p['pct'] }}%; height:100%; background:{{ $p['color'] }}; border-radius:10px; transition:.6s ease;"></div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

    {{-- ── RIGHT COLUMN ── --}}
    <div class="col-lg-8">

        {{-- Quick Access --}}
        <div class="card p-4 mb-4">
            <h6 class="fw-semibold mb-3" style="color:#0f172a; font-size:13px;">
                <i class="bi bi-lightning-charge-fill text-warning me-2"></i>Quick Access
            </h6>
            <div class="row g-2 mb-3">

                <div class="col-6 col-md-3">
                    <a href="{{ route('student.courses') }}"
                       class="d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none"
                       style="background:#ede9fe; border:0.5px solid #c4b5fd; color:#4338ca; transition:.2s; text-align:center;"
                       onmouseover="this.style.background='#ddd6fe'" onmouseout="this.style.background='#ede9fe'">
                        <i class="bi bi-book-fill" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">My Courses</span>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="{{ route('student.attendance') }}"
                       class="d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none"
                       style="background:#d1fae5; border:0.5px solid #6ee7b7; color:#065f46; transition:.2s; text-align:center;"
                       onmouseover="this.style.background='#a7f3d0'" onmouseout="this.style.background='#d1fae5'">
                        <i class="bi bi-calendar-check-fill" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Attendance</span>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="{{ route('student.results') }}"
                       class="d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none"
                       style="background:#fef3c7; border:0.5px solid #fcd34d; color:#92400e; transition:.2s; text-align:center;"
                       onmouseover="this.style.background='#fde68a'" onmouseout="this.style.background='#fef3c7'">
                        <i class="bi bi-bar-chart-fill" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Results</span>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="{{ route('student.fees') }}"
                       class="d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none"
                       style="background:#fee2e2; border:0.5px solid #fca5a5; color:#991b1b; transition:.2s; text-align:center;"
                       onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                        <i class="bi bi-cash-stack" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Fee Status</span>
                    </a>
                </div>

            </div>

            {{-- Transcript full-width button --}}
            <a href="{{ route('student.transcript') }}"
               class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
               style="background:#0f172a; border:0.5px solid #1e293b; transition:.2s;"
               onmouseover="this.style.background='#1e293b'" onmouseout="this.style.background='#0f172a'">
                <div style="width:42px; height:42px; border-radius:10px; background:rgba(99,102,241,.2); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="bi bi-file-earmark-pdf-fill" style="color:#a5b4fc; font-size:20px;"></i>
                </div>
                <div>
                    <div style="color:#f8fafc; font-size:13px; font-weight:500;">Academic Transcript</div>
                    <div style="color:#475569; font-size:11px;">Download your official academic record as PDF</div>
                </div>
                <i class="bi bi-arrow-right ms-auto" style="color:#6366f1; font-size:18px;"></i>
            </a>
        </div>

        {{-- Recent Results --}}
        <div class="card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold mb-0" style="color:#0f172a; font-size:13px;">
                    <i class="bi bi-trophy me-2 text-warning"></i>Recent Results
                </h6>
                <a href="{{ route('student.results') }}" style="font-size:12px; color:#6366f1; text-decoration:none;">
                    View all <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div style="border-radius:8px; overflow:hidden; border:0.5px solid #e2e8f0;">
                <div style="display:grid; grid-template-columns:2fr 2fr 1fr 1fr; font-size:11px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.4px; padding:8px 12px; background:#f8fafc; border-bottom:0.5px solid #e2e8f0;">
                    <div>Course</div><div>Marks</div><div>Grade</div><div>GPA</div>
                </div>
                @forelse($recentResults ?? [] as $result)
                @php
                    $gc = match(true) {
                        ($result->grade == 'A+') => ['bg'=>'#d1fae5','c'=>'#065f46'],
                        ($result->grade == 'A')  => ['bg'=>'#d1fae5','c'=>'#065f46'],
                        str_starts_with($result->grade ?? '', 'B') => ['bg'=>'#fef3c7','c'=>'#92400e'],
                        default => ['bg'=>'#fee2e2','c'=>'#991b1b'],
                    };
                @endphp
                <div style="display:grid; grid-template-columns:2fr 2fr 1fr 1fr; font-size:12px; padding:9px 12px; border-bottom:0.5px solid #f8fafc; align-items:center; color:#334155;">
                    <div style="font-weight:500; color:#0f172a;">{{ $result->course->name ?? '-' }}</div>
                    <div style="color:#64748b;">{{ $result->total_marks }}<span style="font-size:10px;">/100</span></div>
                    <div>
                        <span style="background:{{ $gc['bg'] }}; color:{{ $gc['c'] }}; font-size:10px; font-weight:500; padding:2px 8px; border-radius:20px;">
                            {{ $result->grade }}
                        </span>
                    </div>
                    <div>
                        <span style="background:#dbeafe; color:#1e40af; font-size:10px; font-weight:500; padding:2px 8px; border-radius:20px;">
                            {{ $result->gpa }}
                        </span>
                    </div>
                </div>
                @empty
                <div style="padding:20px; text-align:center; color:#94a3b8; font-size:13px;">
                    <i class="bi bi-inbox" style="font-size:28px; display:block; margin-bottom:6px; color:#cbd5e1;"></i>
                    No results yet
                </div>
                @endforelse
            </div>
        </div>

        {{-- Latest Notices --}}
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold mb-0" style="color:#0f172a; font-size:13px;">
                    <i class="bi bi-megaphone me-2 text-warning"></i>Latest Notices
                </h6>
                <a href="{{ route('student.notices') ?? '#' }}" style="font-size:12px; color:#6366f1; text-decoration:none;">
                    View all <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @forelse($notices ?? [] as $notice)
            @php
                $badge = match($notice->category) {
                    'exam'    => ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'Exam'],
                    'event'   => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'Event'],
                    'holiday' => ['bg'=>'#fef3c7','color'=>'#92400e','label'=>'Holiday'],
                    default   => ['bg'=>'#dbeafe','color'=>'#1d4ed8','label'=>'General'],
                };
            @endphp
            <div style="display:flex; align-items:flex-start; gap:10px; padding:8px 0; border-bottom:0.5px solid #f8fafc;">
                <span style="background:{{ $badge['bg'] }}; color:{{ $badge['color'] }}; font-size:10px; padding:2px 9px; border-radius:20px; white-space:nowrap; margin-top:2px; font-weight:500;">
                    {{ $badge['label'] }}
                </span>
                <div style="flex:1;">
                    <div style="font-size:13px; font-weight:500; color:#0f172a; line-height:1.3;">{{ $notice->title }}</div>
                    <div style="font-size:11px; color:#94a3b8; margin-top:2px;">
                        {{ \Carbon\Carbon::parse($notice->publish_date)->format('d M Y') }}
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:20px 0; color:#94a3b8;">
                <i class="bi bi-bell-slash" style="font-size:28px; display:block; margin-bottom:6px; color:#cbd5e1;"></i>
                No notices available
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection