@extends('layouts.student_app')
@section('title', 'Student Portal | Dashboard')

@section('content')

{{-- Custom Styles for Modern UI Enhancements --}}
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        --hover-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card {
        background: white;
        border-radius: 1.25rem;
        padding: 1.2rem;
        box-shadow: var(--card-shadow);
        transition: var(--hover-transition);
        border: 1px solid rgba(0,0,0,0.03);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.1);
        border-color: rgba(99,102,241,0.2);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-gradient);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .stat-card:hover::after {
        opacity: 1;
    }

    .modern-card {
        background: white;
        border-radius: 1.25rem;
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--hover-transition);
        overflow: hidden;
    }

    .modern-card:hover {
        box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.12);
    }

    .quick-action-btn {
        transition: var(--hover-transition);
        cursor: pointer;
    }

    .quick-action-btn:hover {
        transform: translateY(-3px);
    }

    .grade-badge {
        transition: all 0.2s ease;
    }

    .grade-badge:hover {
        transform: scale(1.05);
    }

    /* Smooth animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease forwards;
    }

    .progress-bar-custom {
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        border-radius: 10px;
        transition: width 1s ease-in-out;
    }

    /* Custom scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

{{-- ── WELCOME BANNER (Enhanced with live time) ── --}}
<div class="animate-fadeInUp" style="background:linear-gradient(105deg, #0f172a 0%, #1e293b 100%); border-radius:1.5rem; padding:24px 32px; margin-bottom:28px; position:relative; overflow:hidden; box-shadow:0 10px 25px -5px rgba(0,0,0,0.1);">
    <div style="position:absolute; right:-30px; top:-30px; width:220px; height:220px; border-radius:50%; background:rgba(99,102,241,.08); pointer-events:none;"></div>
    <div style="position:absolute; right:80px; top:50px; width:130px; height:130px; border-radius:50%; background:rgba(139,92,246,.06); pointer-events:none;"></div>
    
    <div style="position:relative; z-index:1; display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:15px;">
        <div>
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:8px;">
                <h2 style="color:#f8fafc; font-size:22px; font-weight:700; margin:0;">
                    Welcome back, {{ $student->name }} 👋
                </h2>
                <span style="background:rgba(99,102,241,0.2); backdrop-filter:blur(10px); border:1px solid rgba(99,102,241,0.3); border-radius:40px; padding:4px 14px; font-size:11px; font-weight:500; color:#a5b4fc;">
                    <i class="bi bi-shield-check"></i> Verified Student
                </span>
            </div>
            <p style="color:#94a3b8; font-size:13px; margin:0 0 16px 0; max-width:500px;">
                Student Portal — Track your academic progress, attendance, and stay updated with latest notices.
            </p>
            <div style="display:flex; flex-wrap:wrap; gap:10px;">
                <span style="background:rgba(255,255,255,.08); border:0.5px solid rgba(255,255,255,.12); border-radius:24px; padding:5px 16px; font-size:12px; color:#cbd5e1;">
                    📚 {{ $student->department->name ?? 'N/A' }}
                </span>
                <span style="background:rgba(255,255,255,.08); border:0.5px solid rgba(255,255,255,.12); border-radius:24px; padding:5px 16px; font-size:12px; color:#cbd5e1;">
                    🎓 Session {{ $student->session }}
                </span>
                <span style="background:rgba(255,255,255,.08); border:0.5px solid rgba(255,255,255,.12); border-radius:24px; padding:5px 16px; font-size:12px; color:#cbd5e1;">
                    📋 {{ $student->semester }}th Semester
                </span>
                <span style="background:rgba(255,255,255,.08); border:0.5px solid rgba(255,255,255,.12); border-radius:24px; padding:5px 16px; font-size:12px; color:#cbd5e1;">
                    🆔 {{ $student->student_id }}
                </span>
            </div>
        </div>
        
        {{-- Live Date & Time Widget --}}
        <div style="background:rgba(255,255,255,0.03); backdrop-filter:blur(10px); border-radius:1rem; padding:12px 20px; text-align:center; border:1px solid rgba(255,255,255,0.08);">
            <div style="font-size:12px; color:#94a3b8; margin-bottom:5px;">
                <i class="bi bi-calendar3"></i> Current Academic Time
            </div>
            <div style="font-size:20px; font-weight:700; color:#f8fafc;" id="liveDateTime">
                {{ now()->format('d M Y') }}
            </div>
            <div style="font-size:11px; color:#818cf8;" id="liveTime">
                {{ now()->format('h:i A') }}
            </div>
        </div>
    </div>
</div>

{{-- ── STAT CARDS (Enhanced with Icons & Trends) ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                <div class="stat-icon" style="background:linear-gradient(135deg, #ede9fe, #e0e7ff); width:42px; height:42px; border-radius:14px; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-book-fill" style="color:#6366f1; font-size:20px;"></i>
                </div>
                <span style="font-size:11px; font-weight:600; color:#10b981; background:#d1fae5; padding:3px 8px; border-radius:20px;">
                    +{{ $courseCount }}
                </span>
            </div>
            <div class="stat-value" style="font-size:28px; font-weight:800; color:#0f172a;">{{ $courseCount }}</div>
            <div class="stat-label" style="font-size:12px; color:#64748b; margin-top:4px;">Enrolled Courses</div>
            <div class="stat-change flat" style="font-size:11px; color:#6366f1; margin-top:8px;">Active this semester</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                <div class="stat-icon" style="background:linear-gradient(135deg, #d1fae5, #a7f3d0); width:42px; height:42px; border-radius:14px; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-calendar-check-fill" style="color:#059669; font-size:20px;"></i>
                </div>
                @if(($attendanceRate ?? 0) >= 75)
                    <span style="font-size:11px; font-weight:600; color:#10b981; background:#d1fae5; padding:3px 8px; border-radius:20px;">Excellent</span>
                @elseif(($attendanceRate ?? 0) >= 60)
                    <span style="font-size:11px; font-weight:600; color:#f59e0b; background:#fef3c7; padding:3px 8px; border-radius:20px;">Good</span>
                @else
                    <span style="font-size:11px; font-weight:600; color:#ef4444; background:#fee2e2; padding:3px 8px; border-radius:20px;">Needs Care</span>
                @endif
            </div>
            <div class="stat-value" style="font-size:28px; font-weight:800; color:#0f172a;">{{ number_format($attendanceRate ?? 0, 1) }}<span style="font-size:16px;">%</span></div>
            <div class="stat-label" style="font-size:12px; color:#64748b; margin-top:4px;">Attendance Rate</div>
            <div class="stat-change up" style="font-size:11px; color:#10b981; margin-top:8px;">
                <i class="bi bi-arrow-up-short"></i> {{ ($attendanceRate ?? 0) >= 75 ? 'Above threshold' : 'Target: 75%' }}
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                <div class="stat-icon" style="background:linear-gradient(135deg, #fef3c7, #fde68a); width:42px; height:42px; border-radius:14px; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-trophy-fill" style="color:#d97706; font-size:20px;"></i>
                </div>
                @php
                    $cgpa = $cgpa ?? 0;
                    $remark = $cgpa >= 3.75 ? '🏆 Distinction' : ($cgpa >= 3.0 ? '⭐ First Class' : ($cgpa >= 2.5 ? '📘 Second Class' : '⚠️ Needs Improvement'));
                @endphp
                <span style="font-size:11px; font-weight:600; background:rgba(99,102,241,0.1); color:#6366f1; padding:3px 8px; border-radius:20px;">{{ $remark }}</span>
            </div>
            <div class="stat-value" style="font-size:28px; font-weight:800; color:#0f172a;">{{ number_format($cgpa, 2) }}</div>
            <div class="stat-label" style="font-size:12px; color:#64748b; margin-top:4px;">Current CGPA <span style="font-size:10px;">(out of 4.0)</span></div>
            <div class="stat-change flat" style="font-size:11px; color:#d97706; margin-top:8px;">
                <i class="bi bi-graph-up"></i> {{ $cgpa >= 3.5 ? 'Excellent Performance' : ($cgpa >= 3.0 ? 'Good Standing' : 'Focus Required') }}
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                <div class="stat-icon" style="background:linear-gradient(135deg, #fee2e2, #fecaca); width:42px; height:42px; border-radius:14px; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-cash-stack" style="color:#ef4444; font-size:20px;"></i>
                </div>
                @if($feeDue <= 0)
                    <span style="font-size:11px; font-weight:600; color:#10b981; background:#d1fae5; padding:3px 8px; border-radius:20px;">Paid</span>
                @else
                    <span style="font-size:11px; font-weight:600; color:#ef4444; background:#fee2e2; padding:3px 8px; border-radius:20px;">Due</span>
                @endif
            </div>
            <div class="stat-value" style="font-size:22px; font-weight:800; color:#0f172a;">৳{{ number_format($feeDue) }}</div>
            <div class="stat-label" style="font-size:12px; color:#64748b; margin-top:4px;">Fee Due</div>
            <div class="stat-change down" style="font-size:11px; color:#ef4444; margin-top:8px;">
                <i class="bi bi-exclamation-triangle"></i> Due Date: {{ \Carbon\Carbon::parse($feeDueDate ?? now()->addDays(15))->format('d M') ?? 'N/A' }}
            </div>
        </div>
    </div>
</div>

{{-- ── MAIN GRID ── --}}
<div class="row g-4">

    {{-- ── LEFT COLUMN (Profile + Progress + Upcoming Events) ── --}}
    <div class="col-lg-4">

        {{-- Profile Card (Enhanced) --}}
        <div class="modern-card p-4 mb-4">
            <div class="text-center mb-3">
                <div style="width:90px; height:90px; border-radius:50%; background:linear-gradient(135deg, #6366f1, #8b5cf6); color:#fff; display:flex; align-items:center; justify-content:center; font-size:34px; font-weight:700; margin:0 auto 12px; box-shadow:0 8px 20px rgba(99,102,241,0.3);">
                    {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>
                <h5 style="font-size:17px; font-weight:700; color:#0f172a; margin:0 0 3px;">
                    {{ $student->name }}
                </h5>
                <div style="font-size:12px; color:#6366f1; font-weight:500; margin-bottom:8px;">
                    {{ $student->student_id }}
                </div>
                <span style="background:#d1fae5; color:#065f46; font-size:11px; padding:4px 14px; border-radius:40px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                    <i class="bi bi-circle-fill" style="font-size:7px;"></i>
                    {{ ucfirst($student->status ?? 'Active') }}
                </span>
            </div>
            
            <hr style="border-color:#f1f5f9; margin:18px 0;">
            
            <div style="max-height: 340px; overflow-y: auto; padding-right: 5px;" class="custom-scroll">
                @foreach([
                    ['label'=>'Department', 'value'=> $student->department->name ?? '-', 'icon'=>'bi-building', 'color'=>'#6366f1'],
                    ['label'=>'Session',    'value'=> $student->session,                  'icon'=>'bi-calendar', 'color'=>'#059669'],
                    ['label'=>'Semester',   'value'=> $student->semester . 'th Semester', 'icon'=>'bi-layers', 'color'=>'#d97706'],
                    ['label'=>'Gender',     'value'=> ucfirst($student->gender ?? 'Not specified'), 'icon'=>'bi-person', 'color'=>'#8b5cf6'],
                    ['label'=>'Phone',      'value'=> $student->phone ?? 'N/A',           'icon'=>'bi-telephone', 'color'=>'#10b981'],
                    ['label'=>'Email',      'value'=> $student->email,                    'icon'=>'bi-envelope', 'color'=>'#ef4444'],
                    ['label'=>'Blood Group','value'=> $student->blood_group ?? 'N/A',     'icon'=>'bi-droplet', 'color'=>'#dc2626'],
                    ['label'=>'Admission Date','value'=> $student->created_at?->format('d M, Y') ?? 'N/A', 'icon'=>'bi-calendar-plus', 'color'=>'#6366f1'],
                ] as $info)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:0.5px solid #f1f5f9;">
                    <span style="font-size:12px; color:#64748b; display:flex; align-items:center; gap:8px;">
                        <i class="bi {{ $info['icon'] }}" style="color:{{ $info['color'] }}; font-size:14px;"></i>
                        {{ $info['label'] }}
                    </span>
                    <span style="font-size:12px; font-weight:500; color:#0f172a; text-align:right;">
                        {{ $info['value'] }}
                    </span>
                </div>
                @endforeach
            </div>

            {{-- Edit Profile Button --}}
            <button class="btn w-100 mt-3" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; font-size:12px; font-weight:500; color:#6366f1; transition:0.2s;" 
                    onmouseover="this.style.background='#e0e7ff'" onmouseout="this.style.background='#f8fafc'">
                <i class="bi bi-pencil-square"></i> Edit Profile
            </button>
        </div>

        {{-- Semester Progress with Circular Progress (Enhanced) --}}
        <div class="modern-card p-4 mb-4">
            <h6 class="fw-semibold mb-3" style="color:#0f172a; font-size:14px;">
                <i class="bi bi-pie-chart-fill me-2" style="color:#6366f1;"></i>Academic Progress
            </h6>
            
            @php
                $totalCourses = $courseCount;
                $completedCourses = $completedCoursesCount ?? 0;
                $courseProgress = $totalCourses > 0 ? ($completedCourses / $totalCourses) * 100 : 0;
                $attRate = $attendanceRate ?? 0;
                $cgpaPercent = ($cgpa ?? 0) / 4 * 100;
                $feePaidPercent = ($feePaid ?? 0) > 0 && (($feePaid ?? 0) + ($feeDue ?? 0)) > 0 ? (($feePaid ?? 0) / (($feePaid ?? 0) + ($feeDue ?? 0))) * 100 : 0;
            @endphp

            <div class="row g-3 mb-3">
                <div class="col-6 text-center">
                    <div style="position: relative; display: inline-block; width: 100%;">
                        <canvas id="courseProgressChart" width="100" height="100" style="max-width:110px; margin:0 auto;"></canvas>
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                            <div style="font-size:20px; font-weight:800; color:#6366f1;">{{ round($courseProgress) }}%</div>
                            <div style="font-size:9px; color:#64748b;">Courses</div>
                        </div>
                    </div>
                    <div style="margin-top: 8px; font-size:11px; font-weight:500; color:#0f172a;">{{ $completedCourses }}/{{ $totalCourses }} Done</div>
                </div>
                <div class="col-6 text-center">
                    <div style="position: relative; display: inline-block; width: 100%;">
                        <canvas id="attendanceProgressChart" width="100" height="100" style="max-width:110px; margin:0 auto;"></canvas>
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                            <div style="font-size:20px; font-weight:800; color:#059669;">{{ round($attRate) }}%</div>
                            <div style="font-size:9px; color:#64748b;">Attendance</div>
                        </div>
                    </div>
                    <div style="margin-top: 8px; font-size:11px; font-weight:500; color:#0f172a;">{{ $attendanceCount ?? 0 }} days</div>
                </div>
            </div>

            <div class="mt-2">
                <div class="d-flex justify-content-between mb-1">
                    <span style="font-size:11px; color:#64748b;">CGPA Progress</span>
                    <span style="font-size:11px; font-weight:600; color:#0f172a;">{{ number_format($cgpa ?? 0, 2) }} / 4.0</span>
                </div>
                <div style="height:6px; background:#f1f5f9; border-radius:10px; overflow:hidden;">
                    <div class="progress-bar-custom" style="width:{{ $cgpaPercent }}%; height:100%;"></div>
                </div>
                <div class="d-flex justify-content-between mt-3 mb-1">
                    <span style="font-size:11px; color:#64748b;">Fee Payment</span>
                    <span style="font-size:11px; font-weight:600; color:#0f172a;">{{ round($feePaidPercent) }}%</span>
                </div>
                <div style="height:6px; background:#f1f5f9; border-radius:10px; overflow:hidden;">
                    <div style="width:{{ $feePaidPercent }}%; height:100%; background:#f59e0b; border-radius:10px;"></div>
                </div>
            </div>
        </div>

        {{-- Upcoming Events / Class Schedule Preview --}}
        <div class="modern-card p-4">
            <h6 class="fw-semibold mb-3" style="color:#0f172a; font-size:14px;">
                <i class="bi bi-calendar-event me-2" style="color:#6366f1;"></i>Upcoming Events
            </h6>
            @forelse($upcomingEvents ?? [] as $event)
            <div style="display:flex; gap:12px; padding:10px 0; border-bottom:0.5px solid #f1f5f9;">
                <div style="min-width:45px; text-align:center;">
                    <div style="background:#ede9fe; border-radius:12px; padding:6px 0;">
                        <div style="font-size:14px; font-weight:800; color:#6366f1;">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</div>
                        <div style="font-size:9px; color:#64748b;">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</div>
                    </div>
                </div>
                <div>
                    <div style="font-size:13px; font-weight:600; color:#0f172a;">{{ $event->title }}</div>
                    <div style="font-size:11px; color:#64748b;"><i class="bi bi-clock"></i> {{ $event->time ?? 'TBD' }}</div>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:20px; color:#94a3b8;">
                <i class="bi bi-calendar-x" style="font-size:32px; display:block; margin-bottom:6px; color:#cbd5e1;"></i>
                No upcoming events
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── RIGHT COLUMN ── --}}
    <div class="col-lg-8">

        {{-- Quick Access (Enhanced with more actions) --}}
        <div class="modern-card p-4 mb-4">
            <h6 class="fw-semibold mb-3" style="color:#0f172a; font-size:14px;">
                <i class="bi bi-grid-3x3-gap-fill me-2" style="color:#6366f1;"></i>Quick Access
            </h6>
            <div class="row g-2 mb-4">
                <div class="col-4 col-md-3">
                    <a href="{{ route('student.courses') }}" class="quick-action-btn d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none" style="background:#ede9fe; border:0.5px solid #c4b5fd; color:#4338ca; text-align:center; transition:.2s;">
                        <i class="bi bi-book-fill" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Courses</span>
                    </a>
                </div>
                <div class="col-4 col-md-3">
                    <a href="{{ route('student.attendance') }}" class="quick-action-btn d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none" style="background:#d1fae5; border:0.5px solid #6ee7b7; color:#065f46; text-align:center;">
                        <i class="bi bi-calendar-check-fill" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Attendance</span>
                    </a>
                </div>
                <div class="col-4 col-md-3">
                    <a href="{{ route('student.results') }}" class="quick-action-btn d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none" style="background:#fef3c7; border:0.5px solid #fcd34d; color:#92400e; text-align:center;">
                        <i class="bi bi-bar-chart-fill" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Results</span>
                    </a>
                </div>
                <div class="col-4 col-md-3">
                    <a href="{{ route('student.fees') }}" class="quick-action-btn d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none" style="background:#fee2e2; border:0.5px solid #fca5a5; color:#991b1b; text-align:center;">
                        <i class="bi bi-cash-stack" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Fees</span>
                    </a>
                </div>
                <div class="col-4 col-md-3">
                    <a href="{{ route('student.routine') }}" class="quick-action-btn d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none" style="background:#e0e7ff; border:0.5px solid #a5b4fc; color:#3730a3; text-align:center;">
                        <i class="bi bi-table" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Routine</span>
                    </a>
                </div>
                <div class="col-4 col-md-3">
                    <a href="{{ route('student.library') }}" class="quick-action-btn d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none" style="background:#fce7f3; border:0.5px solid #f9a8d4; color:#831843; text-align:center;">
                        <i class="bi bi-journal-bookmark-fill" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Library</span>
                    </a>
                </div>
                <div class="col-4 col-md-3">
                    <a href="{{ route('student.assignments') }}" class="quick-action-btn d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none" style="background:#d1f5ff; border:0.5px solid #7dd3fc; color:#075985; text-align:center;">
                        <i class="bi bi-journal-text" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Assignments</span>
                    </a>
                </div>
                <div class="col-4 col-md-3">
                    <a href="{{ route('student.settings') }}" class="quick-action-btn d-flex flex-column align-items-center gap-2 p-3 rounded-3 text-decoration-none" style="background:#f1f5f9; border:0.5px solid #cbd5e1; color:#475569; text-align:center;">
                        <i class="bi bi-gear-fill" style="font-size:22px;"></i>
                        <span style="font-size:12px; font-weight:500;">Settings</span>
                    </a>
                </div>
            </div>

            {{-- Transcript Button --}}
            <a href="{{ route('student.transcript') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="background:linear-gradient(105deg, #0f172a, #1e293b); transition:.2s;">
                <div style="width:44px; height:44px; border-radius:12px; background:rgba(99,102,241,.2); display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-file-earmark-pdf-fill" style="color:#a5b4fc; font-size:22px;"></i>
                </div>
                <div>
                    <div style="color:#f8fafc; font-size:14px; font-weight:600;">Official Transcript</div>
                    <div style="color:#64748b; font-size:11px;">Download your complete academic record</div>
                </div>
                <i class="bi bi-download ms-auto" style="color:#818cf8; font-size:18px;"></i>
            </a>
        </div>

        {{-- Recent Results with better visualization --}}
        <div class="modern-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold mb-0" style="color:#0f172a; font-size:14px;">
                    <i class="bi bi-trophy me-2 text-warning"></i>Recent Results
                </h6>
                <a href="{{ route('student.results') }}" style="font-size:12px; color:#6366f1; text-decoration:none; font-weight:500;">
                    View all <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div style="border-radius:12px; overflow:hidden; border:0.5px solid #e2e8f0;">
                <div style="display:grid; grid-template-columns:2.5fr 1.5fr 1fr 1.2fr; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.5px; padding:10px 14px; background:#f8fafc; border-bottom:0.5px solid #e2e8f0;">
                    <div>Course</div><div>Marks</div><div>Grade</div><div>GPA</div>
                </div>
                @forelse($recentResults ?? [] as $result)
                @php
                    $gradeColor = match(true) {
                        ($result->grade == 'A+') => ['bg'=>'#d1fae5','c'=>'#065f46','icon'=>'⭐'],
                        ($result->grade == 'A')  => ['bg'=>'#d1fae5','c'=>'#065f46','icon'=>'📘'],
                        str_starts_with($result->grade ?? '', 'B') => ['bg'=>'#fef3c7','c'=>'#92400e','icon'=>'📗'],
                        str_starts_with($result->grade ?? '', 'C') => ['bg'=>'#fee2e2','c'=>'#991b1b','icon'=>'📙'],
                        default => ['bg'=>'#ffe4e2','c'=>'#991b1b','icon'=>'⚠️'],
                    };
                @endphp
                <div style="display:grid; grid-template-columns:2.5fr 1.5fr 1fr 1.2fr; font-size:12px; padding:10px 14px; border-bottom:0.5px solid #f8fafc; align-items:center; color:#334155;">
                    <div style="font-weight:600; color:#0f172a;">{{ $result->course->name ?? $result->course_code ?? '-' }}</div>
                    <div style="color:#64748b;">{{ $result->total_marks ?? $result->marks }}<span style="font-size:10px;">/100</span></div>
                    <div>
                        <span class="grade-badge" style="background:{{ $gradeColor['bg'] }}; color:{{ $gradeColor['c'] }}; font-size:11px; font-weight:600; padding:3px 10px; border-radius:30px; display:inline-flex; align-items:center; gap:4px;">
                            {{ $gradeColor['icon'] }} {{ $result->grade }}
                        </span>
                    </div>
                    <div>
                        <span style="background:#dbeafe; color:#1e40af; font-size:11px; font-weight:600; padding:3px 10px; border-radius:30px;">
                            {{ number_format($result->gpa ?? 0, 2) }}
                        </span>
                    </div>
                </div>
                @empty
                <div style="padding:30px; text-align:center; color:#94a3b8;">
                    <i class="bi bi-inbox" style="font-size:36px; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                    No results published yet
                </div>
                @endforelse
            </div>
        </div>

        {{-- Latest Notices with filtering & search --}}
        <div class="modern-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h6 class="fw-semibold mb-0" style="color:#0f172a; font-size:14px;">
                    <i class="bi bi-megaphone me-2 text-warning"></i>Latest Announcements
                </h6>
                <div class="d-flex gap-2">
                    <select id="noticeFilter" style="font-size:11px; padding:4px 8px; border-radius:8px; border:1px solid #e2e8f0; background:white;">
                        <option value="all">All</option>
                        <option value="exam">📝 Exam</option>
                        <option value="event">🎉 Event</option>
                        <option value="holiday">🎊 Holiday</option>
                        <option value="general">📢 General</option>
                    </select>
                    <a href="{{ route('student.notices') ?? '#' }}" style="font-size:12px; color:#6366f1; text-decoration:none; font-weight:500;">
                        View all <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div id="noticesList">
                @forelse($notices ?? [] as $notice)
                @php
                    $badge = match($notice->category) {
                        'exam'    => ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'📝 Exam','icon'=>'bi bi-pencil-square'],
                        'event'   => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'🎉 Event','icon'=>'bi bi-calendar-heart'],
                        'holiday' => ['bg'=>'#fef3c7','color'=>'#92400e','label'=>'🎊 Holiday','icon'=>'bi bi-umbrella'],
                        default   => ['bg'=>'#dbeafe','color'=>'#1d4ed8','label'=>'📢 General','icon'=>'bi bi-megaphone'],
                    };
                @endphp
                <div class="notice-item" data-category="{{ $notice->category }}" style="display:flex; align-items:flex-start; gap:12px; padding:12px 0; border-bottom:0.5px solid #f1f5f9; transition:0.2s;">
                    <div style="width:36px; height:36px; background:{{ $badge['bg'] }}; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="{{ $badge['icon'] }}" style="color:{{ $badge['color'] }}; font-size:16px;"></i>
                    </div>
                    <div style="flex:1;">
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:5px; margin-bottom:4px;">
                            <span style="font-size:13px; font-weight:600; color:#0f172a;">{{ $notice->title }}</span>
                            <span style="background:{{ $badge['bg'] }}; color:{{ $badge['color'] }}; font-size:10px; padding:2px 8px; border-radius:20px; font-weight:500;">
                                {{ $badge['label'] }}
                            </span>
                        </div>
                        <div style="font-size:12px; color:#64748b; line-height:1.4;">{{ $notice->description ?? '' }}</div>
                        <div style="font-size:10px; color:#94a3b8; margin-top:6px;">
                            <i class="bi bi-clock-history"></i> {{ \Carbon\Carbon::parse($notice->publish_date ?? $notice->created_at)->diffForHumans() }}
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align:center; padding:30px 0; color:#94a3b8;">
                    <i class="bi bi-bell-slash" style="font-size:36px; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                    No announcements at the moment
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Live Date & Time
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { day: 'numeric', month: 'short', year: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };
        document.getElementById('liveDateTime').innerHTML = now.toLocaleDateString('en-US', dateOptions);
        document.getElementById('liveTime').innerHTML = now.toLocaleTimeString('en-US', timeOptions);
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Circular Progress Charts
    const courseCtx = document.getElementById('courseProgressChart')?.getContext('2d');
    if(courseCtx) {
        new Chart(courseCtx, {
            type: 'doughnut',
            data: { datasets: [{ data: [{{ $courseProgress }}, 100 - {{ $courseProgress }}], backgroundColor: ['#6366f1', '#e2e8f0'], borderWidth: 0 }] },
            options: { cutout: '70%', plugins: { tooltip: { enabled: false }, legend: { display: false } }, responsive: true, maintainAspectRatio: true }
        });
    }

    const attendanceCtx = document.getElementById('attendanceProgressChart')?.getContext('2d');
    if(attendanceCtx) {
        new Chart(attendanceCtx, {
            type: 'doughnut',
            data: { datasets: [{ data: [{{ $attendanceRate ?? 0 }}, 100 - ({{ $attendanceRate ?? 0 }})], backgroundColor: ['#059669', '#e2e8f0'], borderWidth: 0 }] },
            options: { cutout: '70%', plugins: { tooltip: { enabled: false }, legend: { display: false } }, responsive: true, maintainAspectRatio: true }
        });
    }

    // Notice Filtering
    const filterSelect = document.getElementById('noticeFilter');
    const noticeItems = document.querySelectorAll('.notice-item');
    if(filterSelect) {
        filterSelect.addEventListener('change', function() {
            const category = this.value;
            noticeItems.forEach(item => {
                if(category === 'all' || item.dataset.category === category) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Animate progress bars on load
    window.addEventListener('load', () => {
        const bars = document.querySelectorAll('.progress-bar-custom');
        bars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => { bar.style.width = width; }, 100);
        });
    });
</script>

@endsection