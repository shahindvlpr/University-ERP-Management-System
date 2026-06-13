use Illuminate\Validation\Rules\Date;
@extends('layouts.student_app')
@section('title', 'Student Portal | Dashboard')

@section('content')

{{-- Custom Styles for Premium UI --}}
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --primary-light: #818cf8;
        --secondary: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
        --dark: #0f172a;
        --gray: #64748b;
        --light-gray: #f1f5f9;
        --card-radius: 1.5rem;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%);
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        border-radius: var(--card-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2);
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: var(--card-radius);
        padding: 1.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: var(--transition);
        border: 1px solid rgba(0, 0, 0, 0.03);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        transform: scaleX(0);
        transition: transform 0.5s ease;
    }

    .stat-card:hover::after {
        transform: scaleX(1);
    }

    /* Modern Cards */
    .modern-card {
        background: white;
        border-radius: var(--card-radius);
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: var(--transition);
        overflow: hidden;
    }

    .modern-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    /* Quick Action Buttons */
    .quick-action-btn {
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        border-radius: 1rem;
        text-decoration: none;
        text-align: center;
        background: var(--light-gray);
        color: var(--dark);
    }

    .quick-action-btn:hover {
        transform: translateY(-5px);
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
    }

    .quick-action-btn i {
        font-size: 1.5rem;
        transition: var(--transition);
    }

    /* Profile Avatar */
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
    }

    /* Progress Bars */
    .progress-bar-custom {
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        border-radius: 10px;
        transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Notices */
    .notice-item {
        transition: var(--transition);
        border-radius: 1rem;
        padding: 1rem;
    }

    .notice-item:hover {
        background: var(--light-gray);
        transform: translateX(5px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .welcome-banner {
            padding: 1.25rem;
        }
        .stat-card {
            padding: 1rem;
        }
        .quick-action-btn {
            padding: 0.75rem;
        }
        .quick-action-btn i {
            font-size: 1.25rem;
        }
        .quick-action-btn span {
            font-size: 0.75rem;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
</style>

<div class="animate-fadeInUp">
    {{-- Welcome Banner --}}
    <div class="welcome-banner">
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 0.75rem;">
                        <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin: 0;">
                            Welcome back, {{ $student->name }}! 👋
                        </h2>
                        <span style="background: rgba(79, 70, 229, 0.3); backdrop-filter: blur(10px); border: 1px solid rgba(79, 70, 229, 0.5); border-radius: 40px; padding: 0.25rem 1rem; font-size: 0.75rem; color: var(--primary-light);">
                            <i class="bi bi-shield-check"></i> Verified Student
                        </span>
                    </div>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.875rem; margin-bottom: 1rem;">
                        Track your academic progress, attendance, and stay updated with latest notices.
                    </p>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <span style="background: rgba(255,255,255,0.1); border-radius: 40px; padding: 0.25rem 1rem; font-size: 0.75rem; color: #cbd5e1;">
                            📚 {{ $student->department->name ?? 'N/A' }}
                        </span>
                        <span style="background: rgba(255,255,255,0.1); border-radius: 40px; padding: 0.25rem 1rem; font-size: 0.75rem; color: #cbd5e1;">
                            🎓 Session {{ $student->session ?? 'N/A' }}
                        </span>
                        <span style="background: rgba(255,255,255,0.1); border-radius: 40px; padding: 0.25rem 1rem; font-size: 0.75rem; color: #cbd5e1;">
                            📋 {{ $student->semester ?? 'N/A' }}{{ is_numeric($student->semester) ? 'th' : '' }} Semester
                        </span>
                        <span style="background: rgba(255,255,255,0.1); border-radius: 40px; padding: 0.25rem 1rem; font-size: 0.75rem; color: #cbd5e1;">
                            🆔 {{ $student->student_id }}
                        </span>
                    </div>
                </div>
                
                {{-- Live Time Widget --}}
                <div style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border-radius: 1rem; padding: 0.75rem 1.25rem; text-align: center; border: 1px solid rgba(255,255,255,0.1);">
                    <div style="font-size: 0.7rem; color: #94a3b8;">
                        <i class="bi bi-calendar3"></i> Current Time
                    </div>
                    <div style="font-size: 1.25rem; font-weight: 700; color: white;" id="liveDateTime">
                        {{ now()->format('d M Y') }}
                    </div>
                    <div style="font-size: 0.75rem; color: var(--primary-light);" id="liveTime">
                        {{ now()->format('h:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #ede9fe, #e0e7ff); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-book-fill" style="color: var(--primary); font-size: 1.25rem;"></i>
                    </div>
                    <span style="background: #d1fae5; color: #065f46; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">
                        Active
                    </span>
                </div>
                <div style="font-size: 1.75rem; font-weight: 800; color: var(--dark);">{{ $courseCount ?? 0 }}</div>
                <div style="font-size: 0.75rem; color: var(--gray);">Enrolled Courses</div>
                <div style="font-size: 0.7rem; color: var(--primary); margin-top: 0.5rem;">
                    <i class="bi bi-arrow-right-short"></i> Current Semester
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-calendar-check-fill" style="color: #059669; font-size: 1.25rem;"></i>
                    </div>
                    @php $attRate = $attendanceRate ?? 0; @endphp
                    <span style="background: {{ $attRate >= 75 ? '#d1fae5' : ($attRate >= 60 ? '#fef3c7' : '#fee2e2') }}; color: {{ $attRate >= 75 ? '#065f46' : ($attRate >= 60 ? '#92400e' : '#991b1b') }}; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">
                        {{ $attRate >= 75 ? 'Excellent' : ($attRate >= 60 ? 'Good' : 'Needs Care') }}
                    </span>
                </div>
                <div style="font-size: 1.75rem; font-weight: 800; color: var(--dark);">{{ number_format($attRate, 1) }}<span style="font-size: 1rem;">%</span></div>
                <div style="font-size: 0.75rem; color: var(--gray);">Attendance Rate</div>
                <div style="font-size: 0.7rem; color: #10b981; margin-top: 0.5rem;">
                    <i class="bi bi-arrow-up-short"></i> Target: 75%
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-trophy-fill" style="color: #d97706; font-size: 1.25rem;"></i>
                    </div>
                    @php $cgpa = $cgpa ?? 0; @endphp
                    <span style="background: rgba(79,70,229,0.1); color: var(--primary); padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">
                        {{ $cgpa >= 3.75 ? '🏆 Distinction' : ($cgpa >= 3.0 ? '⭐ First Class' : ($cgpa >= 2.5 ? '📘 Second' : '⚠️ Needs Improvement')) }}
                    </span>
                </div>
                <div style="font-size: 1.75rem; font-weight: 800; color: var(--dark);">{{ number_format($cgpa, 2) }}</div>
                <div style="font-size: 0.75rem; color: var(--gray);">Current CGPA <span style="font-size: 0.65rem;">(out of 4.0)</span></div>
                <div style="font-size: 0.7rem; color: #d97706; margin-top: 0.5rem;">
                    <i class="bi bi-graph-up"></i> {{ $cgpa >= 3.5 ? 'Excellent Performance' : ($cgpa >= 3.0 ? 'Good Standing' : 'Focus Required') }}
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #fee2e2, #fecaca); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-cash-stack" style="color: #ef4444; font-size: 1.25rem;"></i>
                    </div>
                    @php $feeDue = $feeDue ?? 0; @endphp
                    <span style="background: {{ $feeDue <= 0 ? '#d1fae5' : '#fee2e2' }}; color: {{ $feeDue <= 0 ? '#065f46' : '#991b1b' }}; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">
                        {{ $feeDue <= 0 ? 'Paid' : 'Due' }}
                    </span>
                </div>
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--dark);">৳{{ number_format($feeDue) }}</div>
                <div style="font-size: 0.75rem; color: var(--gray);">Fee Due</div>
                <div style="font-size: 0.7rem; color: #ef4444; margin-top: 0.5rem;">
                    <i class="bi bi-exclamation-triangle"></i> Pay before deadline
                </div>
            </div>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="row g-4">
        
        {{-- Left Column --}}
        <div class="col-lg-4">
            
            {{-- Profile Card --}}
            <div class="modern-card p-4 mb-4">
                <div class="text-center">
                    <div class="profile-avatar">
                        <span style="font-size: 2.5rem; font-weight: 700; color: white;">
                            {{ strtoupper(substr($student->name, 0, 1)) }}
                        </span>
                    </div>
                    <h5 style="font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.25rem;">
                        {{ $student->name }}
                    </h5>
                    <div style="font-size: 0.75rem; color: var(--primary); margin-bottom: 0.5rem;">
                        {{ $student->student_id }}
                    </div>
                    <span style="background: #d1fae5; color: #065f46; font-size: 0.7rem; padding: 0.25rem 1rem; border-radius: 40px; font-weight: 600;">
                        <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> {{ ucfirst($student->status ?? 'Active') }}
                    </span>
                </div>
                
                <hr style="margin: 1.25rem 0;">
                
                <div style="max-height: 340px; overflow-y: auto;">
                    @foreach([
                        ['label'=>'Department', 'value'=> $student->department->name ?? '-', 'icon'=>'bi-building'],
                        ['label'=>'Session', 'value'=> $student->session ?? '-', 'icon'=>'bi-calendar'],
                        ['label'=>'Semester', 'value'=> ($student->semester ?? 'N/A') . (is_numeric($student->semester) ? 'th' : ''), 'icon'=>'bi-layers'],
                        ['label'=>'Gender', 'value'=> ucfirst($student->gender ?? 'Not specified'), 'icon'=>'bi-person'],
                        ['label'=>'Phone', 'value'=> $student->phone ?? 'N/A', 'icon'=>'bi-telephone'],
                        ['label'=>'Email', 'value'=> $student->email, 'icon'=>'bi-envelope'],
                        ['label'=>'Blood Group', 'value'=> $student->blood_group ?? 'N/A', 'icon'=>'bi-droplet'],
                    ] as $info)
                    <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid #f1f5f9;">
                        <span style="font-size: 0.75rem; color: var(--gray); display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi {{ $info['icon'] }}" style="color: var(--primary);"></i>
                            {{ $info['label'] }}
                        </span>
                        <span style="font-size: 0.75rem; font-weight: 500; color: var(--dark); text-align: right;">
                            {{ $info['value'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Academic Progress --}}
            <div class="modern-card p-4 mb-4">
                <h6 style="font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-pie-chart-fill" style="color: var(--primary);"></i> Academic Progress
                </h6>
                
                @php
                    $totalCourses = $courseCount ?? 0;
                    $completedCourses = $completedCoursesCount ?? 0;
                    $courseProgress = $totalCourses > 0 ? ($completedCourses / $totalCourses) * 100 : 0;
                @endphp
                
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                        <span style="font-size: 0.7rem; color: var(--gray);">Course Completion</span>
                        <span style="font-size: 0.7rem; font-weight: 600;">{{ round($courseProgress) }}%</span>
                    </div>
                    <div style="height: 6px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                        <div class="progress-bar-custom" style="width: 0%; height: 100%;"></div>
                    </div>
                    <div style="font-size: 0.7rem; color: var(--gray); margin-top: 0.25rem;">
                        {{ $completedCourses }}/{{ $totalCourses }} Courses Completed
                    </div>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                        <span style="font-size: 0.7rem; color: var(--gray);">CGPA Progress</span>
                        <span style="font-size: 0.7rem; font-weight: 600;">{{ number_format($cgpa ?? 0, 2) }} / 4.0</span>
                    </div>
                    <div style="height: 6px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                        <div class="progress-bar-custom" style="width: 0%; height: 100%;"></div>
                    </div>
                </div>
                
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                        <span style="font-size: 0.7rem; color: var(--gray);">Fee Payment</span>
                        @php
                            $totalFee = ($feePaid ?? 0) + ($feeDue ?? 0);
                            $feePercent = $totalFee > 0 ? round((($feePaid ?? 0) / $totalFee) * 100) : 0;
                        @endphp
                        <span style="font-size: 0.7rem; font-weight: 600;">{{ $feePercent }}%</span>
                    </div>
                    <div style="height: 6px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                        <div style="width: 0%; height: 100%; background: linear-gradient(90deg, #f59e0b, #f97316); border-radius: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Right Column --}}
        <div class="col-lg-8">
            
            {{-- Quick Access --}}
            <div class="modern-card p-4 mb-4">
                <h6 style="font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-grid-3x3-gap-fill" style="color: var(--primary);"></i> Quick Access
                </h6>
                <div class="row g-2 mb-4">
                    <div class="col-4 col-md-3">
                        <a href="{{ route('student.courses') }}" class="quick-action-btn">
                            <i class="bi bi-book-fill"></i>
                            <span>Courses</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-3">
                        <a href="{{ route('student.attendance') }}" class="quick-action-btn">
                            <i class="bi bi-calendar-check-fill"></i>
                            <span>Attendance</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-3">
                        <a href="{{ route('student.results') }}" class="quick-action-btn">
                            <i class="bi bi-bar-chart-fill"></i>
                            <span>Results</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-3">
                        <a href="{{ route('student.fees') }}" class="quick-action-btn">
                            <i class="bi bi-cash-stack"></i>
                            <span>Fees</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-3">
                        <a href="{{ route('student.routine') }}" class="quick-action-btn">
                            <i class="bi bi-table"></i>
                            <span>Routine</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-3">
                        <a href="{{ route('student.transcript') }}" class="quick-action-btn">
                            <i class="bi bi-file-text-fill"></i>
                            <span>Transcript</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-3">
                        <a href="{{ route('student.library') }}" class="quick-action-btn">
                            <i class="bi bi-journal-bookmark-fill"></i>
                            <span>Library</span>
                        </a>
                    </div>
                    <div class="col-4 col-md-3">
                        <a href="{{ route('student.settings') }}" class="quick-action-btn">
                            <i class="bi bi-gear-fill"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                </div>
                
                <div class="mt-2 p-3 rounded-3" style="background: linear-gradient(105deg, #0f172a, #1e293b);">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 44px; height: 44px; background: rgba(79,70,229,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-file-earmark-pdf-fill" style="color: #a5b4fc; font-size: 1.25rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div style="color: white; font-size: 0.85rem; font-weight: 600;">Official Transcript</div>
                            <div style="color: #64748b; font-size: 0.7rem;">Download your complete academic record</div>
                        </div>
                        <a href="{{ route('student.transcript') }}" style="color: #818cf8;">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- Recent Results --}}
            <div class="modern-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0" style="font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-trophy" style="color: var(--warning);"></i> Recent Results
                    </h6>
                    <a href="{{ route('student.results') }}" style="font-size: 0.75rem; color: var(--primary); text-decoration: none;">
                        View all <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                
                @forelse($recentResults ?? [] as $result)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div style="font-weight: 600; font-size: 0.85rem;">{{ $result->course->name ?? 'N/A' }}</div>
                        <div style="font-size: 0.7rem; color: var(--gray);">Course</div>
                    </div>
                    <div class="text-center">
                        <div style="font-weight: 700; font-size: 0.85rem;">{{ $result->marks ?? $result->total_marks ?? 'N/A' }}</div>
                        <div style="font-size: 0.7rem; color: var(--gray);">Marks</div>
                    </div>
                    <div>
                        <span style="background: #d1fae5; color: #065f46; padding: 0.2rem 0.8rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">
                            {{ $result->grade ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="text-center">
                        <div style="font-weight: 700; font-size: 0.85rem;">{{ number_format($result->gpa ?? 0, 2) }}</div>
                        <div style="font-size: 0.7rem; color: var(--gray);">GPA</div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="bi bi-inbox" style="font-size: 2rem; color: #cbd5e1;"></i>
                    <p style="color: var(--gray); font-size: 0.85rem; margin-top: 0.5rem;">No results published yet</p>
                </div>
                @endforelse
            </div>
            
            {{-- Latest Notices --}}
            <div class="modern-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h6 class="mb-0" style="font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-megaphone" style="color: var(--warning);"></i> Latest Announcements
                    </h6>
                    <div class="d-flex gap-2">
                        <select id="noticeFilter" class="form-select form-select-sm" style="width: auto; font-size: 0.7rem; border-radius: 10px;">
                            <option value="all">All</option>
                            <option value="exam">📝 Exam</option>
                            <option value="event">🎉 Event</option>
                            <option value="holiday">🎊 Holiday</option>
                            <option value="general">📢 General</option>
                        </select>
                        <a href="{{ route('student.notices') }}" style="font-size: 0.75rem; color: var(--primary); text-decoration: none;">
                            View all <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                @forelse($notices ?? [] as $notice)
                @php
                    $badge = match($notice->category) {
                        'exam' => ['bg'=>'#fee2e2','color'=>'#991b1b','icon'=>'📝'],
                        'event' => ['bg'=>'#d1fae5','color'=>'#065f46','icon'=>'🎉'],
                        'holiday' => ['bg'=>'#fef3c7','color'=>'#92400e','icon'=>'🎊'],
                        default => ['bg'=>'#dbeafe','color'=>'#1d4ed8','icon'=>'📢'],
                    };
                @endphp
                <div class="notice-item" data-category="{{ $notice->category }}">
                    <div class="d-flex gap-3">
                        <div style="width: 32px; height: 32px; background: {{ $badge['bg'] }}; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <span style="font-size: 1rem;">{{ $badge['icon'] }}</span>
                        </div>
                        <div class="flex-grow-1">
                            <div style="font-weight: 600; font-size: 0.85rem;">{{ $notice->title }}</div>
                            <div style="font-size: 0.7rem; color: var(--gray);">{{ $notice->description ?? '' }}</div>
                            <div style="font-size: 0.65rem; color: var(--gray); margin-top: 0.25rem;">
                                <i class="bi bi-clock-history"></i> {{ \Carbon\Carbon::parse($notice->created_at)->diffForHumans() }}
                            </div>
                        </div>
                        <span style="background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.65rem; height: fit-content;">
                            {{ ucfirst($notice->category ?? 'General') }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="bi bi-bell-slash" style="font-size: 2rem; color: #cbd5e1;"></i>
                    <p style="color: var(--gray); font-size: 0.85rem; margin-top: 0.5rem;">No announcements at the moment</p>
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
        document.getElementById('liveDateTime').innerHTML = now.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
        document.getElementById('liveTime').innerHTML = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Animate progress bars
    window.addEventListener('load', () => {
        const bars = document.querySelectorAll('.progress-bar-custom, .progress-fill');
        bars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => { bar.style.width = width; }, 200);
        });
    });
    
    // Notice Filter
    const filterSelect = document.getElementById('noticeFilter');
    const noticeItems = document.querySelectorAll('.notice-item');
    if(filterSelect) {
        filterSelect.addEventListener('change', function() {
            const category = this.value;
            noticeItems.forEach(item => {
                if(category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
</script>

@endsection