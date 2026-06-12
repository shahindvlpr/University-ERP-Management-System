@extends('layouts.teacher_app')

@section('title', 'Teacher Dashboard')

@section('content')

<style>
    /* Modern Dashboard Styles */
    .dashboard-wrapper {
        padding: 20px 0;
    }

    /* Welcome Section */
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .welcome-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }

    .welcome-badge {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 40px;
        font-size: 12px;
        display: inline-block;
        margin-bottom: 15px;
    }

    /* Stats Cards */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 800;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .stat-trend {
        font-size: 11px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .trend-up { color: #10b981; }
    .trend-down { color: #ef4444; }

    /* Course Cards */
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .course-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
    }

    .course-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .course-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 15px 20px;
        color: white;
    }

    .course-code {
        font-size: 11px;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .course-title {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
    }

    .course-body {
        padding: 15px 20px;
    }

    .course-stats {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
    }

    .stat-item {
        text-align: center;
        flex: 1;
    }

    .stat-item .value {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
    }

    .stat-item .label {
        font-size: 10px;
        color: #6c757d;
    }

    .progress-section {
        margin-bottom: 15px;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .progress-bar-custom {
        height: 6px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 1s ease;
    }

    .btn-course {
        width: 100%;
        padding: 8px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        background: #f8f9fa;
        color: #667eea;
        border: 1px solid #e9ecef;
        transition: all 0.3s;
        display: inline-block;
        text-decoration: none;
    }

    .btn-course:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    /* Schedule List */
    .schedule-list {
        background: white;
        border-radius: 16px;
        padding: 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .schedule-item {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.2s;
    }

    .schedule-item:hover {
        background: #f8f9fa;
    }

    .schedule-time {
        min-width: 100px;
    }

    .time-badge {
        background: #e0e7ff;
        color: #4338ca;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .schedule-info {
        flex: 1;
    }

    .schedule-course {
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 3px;
    }

    .schedule-location {
        font-size: 11px;
        color: #6c757d;
    }

    .schedule-students {
        font-size: 11px;
        color: #10b981;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .action-btn {
        padding: 12px;
        border-radius: 12px;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .action-btn i {
        font-size: 24px;
    }

    .action-btn span {
        font-size: 11px;
        font-weight: 500;
    }

    .action-btn:hover {
        transform: translateY(-3px);
    }

    /* Notice List */
    .notice-list {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .notice-item {
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.2s;
    }

    .notice-item:hover {
        background: #f8f9fa;
    }

    .notice-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .notice-meta {
        font-size: 10px;
        color: #6c757d;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: white;
        border-radius: 16px;
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e0;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .stat-number {
            font-size: 24px;
        }
        .schedule-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        .action-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-wrapper">
    {{-- Welcome Section --}}
    <div class="welcome-section">
        <div style="position: relative; z-index: 1;">
            <div class="welcome-badge">
                <i class="fas fa-chalkboard-teacher me-2"></i> Teacher Portal
            </div>
            <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                Welcome back, {{ $teacher->name }}! 👋
            </h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                Here's what's happening with your courses and students today.
            </p>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(102,126,234,0.1);">
                    <i class="fas fa-book" style="color: #667eea; font-size: 28px;"></i>
                </div>
                <div class="stat-number">{{ $courseCount ?? 0 }}</div>
                <div class="stat-label">My Courses</div>
                <div class="stat-trend">
                    <i class="fas fa-check-circle trend-up"></i>
                    <span>Active this semester</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16,185,129,0.1);">
                    <i class="fas fa-users" style="color: #10b981; font-size: 28px;"></i>
                </div>
                <div class="stat-number">{{ $studentCount ?? 0 }}</div>
                <div class="stat-label">Total Students</div>
                <div class="stat-trend">
                    <i class="fas fa-user-plus trend-up"></i>
                    <span>Across all courses</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245,158,11,0.1);">
                    <i class="fas fa-clock" style="color: #f59e0b; font-size: 28px;"></i>
                </div>
                <div class="stat-number">{{ $routineCount ?? 0 }}</div>
                <div class="stat-label">Weekly Classes</div>
                <div class="stat-trend">
                    <i class="fas fa-calendar-week trend-up"></i>
                    <span>This week</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239,68,68,0.1);">
                    <i class="fas fa-calendar-day" style="color: #ef4444; font-size: 28px;"></i>
                </div>
                <div class="stat-number">{{ $todayClasses ?? 0 }}</div>
                <div class="stat-label">Today's Classes</div>
                <div class="stat-trend">
                    <i class="fas fa-hourglass-start trend-up"></i>
                    <span>Upcoming</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column - Courses & Schedule --}}
        <div class="col-lg-7">
            {{-- My Courses Section --}}
            <div class="section-title">
                <span><i class="fas fa-graduation-cap me-2" style="color: #667eea;"></i> My Courses</span>
                <a href="{{ route('teacher.courses') }}" style="font-size: 12px; color: #667eea; text-decoration: none;">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            
            @if(isset($courses) && count($courses) > 0)
                @foreach($courses as $course)
                    <div class="course-card">
                        <div class="course-header">
                            <div class="course-code">{{ $course->code ?? 'N/A' }}</div>
                            <h4 class="course-title">{{ $course->name }}</h4>
                        </div>
                        <div class="course-body">
                            <div class="course-stats">
                                <div class="stat-item">
                                    <div class="value">{{ $course->students_count ?? 0 }}</div>
                                    <div class="label">Students</div>
                                </div>
                                <div class="stat-item">
                                    <div class="value">{{ $course->attendance_rate ?? 0 }}%</div>
                                    <div class="label">Attendance</div>
                                </div>
                                <div class="stat-item">
                                    <div class="value">{{ $course->assignment_count ?? 0 }}</div>
                                    <div class="label">Assignments</div>
                                </div>
                            </div>
                            <div class="progress-section">
                                <div class="progress-label">
                                    <span>Course Progress</span>
                                    <span>{{ $course->progress ?? 0 }}%</span>
                                </div>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="width: 0%; background: linear-gradient(90deg, #667eea, #764ba2);"></div>
                                </div>
                            </div>
                            <a href="{{ route('teacher.course.details', $course->id) }}" class="btn-course">
                                <i class="fas fa-arrow-right me-1"></i> Manage Course
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-book-open"></i>
                    <p>No courses assigned yet.</p>
                </div>
            @endif

            {{-- Today's Schedule --}}
            <div class="section-title mt-4">
                <span><i class="fas fa-calendar-alt me-2" style="color: #f59e0b;"></i> Today's Schedule</span>
                <a href="{{ route('teacher.routine') }}" style="font-size: 12px; color: #667eea; text-decoration: none;">Full Routine <i class="fas fa-arrow-right"></i></a>
            </div>
            
            @if(isset($todaySchedule) && count($todaySchedule) > 0)
                <div class="schedule-list">
                    @foreach($todaySchedule as $schedule)
                        <div class="schedule-item">
                            <div class="schedule-time">
                                <span class="time-badge">{{ $schedule->start_time }} - {{ $schedule->end_time }}</span>
                            </div>
                            <div class="schedule-info">
                                <div class="schedule-course">{{ $schedule->course->name ?? 'N/A' }}</div>
                                <div class="schedule-location">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $schedule->room ?? 'Room TBD' }}
                                </div>
                            </div>
                            <div class="schedule-students">
                                <i class="fas fa-users me-1"></i> {{ $schedule->enrolled_students ?? 0 }} students
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-check"></i>
                    <p>No classes scheduled for today.</p>
                </div>
            @endif
        </div>

        {{-- Right Column - Quick Actions, Notices, Stats --}}
        <div class="col-lg-5">
            {{-- Quick Actions --}}
            <div class="quick-actions mb-4">
                <div class="section-title" style="margin-bottom: 15px; border-bottom: none; padding-bottom: 0;">
                    <span><i class="fas fa-bolt me-2" style="color: #f59e0b;"></i> Quick Actions</span>
                </div>
                <div class="action-grid">
                    <a href="{{ route('teacher.attendance.mark') }}" class="action-btn" style="background: #e0e7ff; color: #4338ca;">
                        <i class="fas fa-check-circle"></i>
                        <span>Mark Attendance</span>
                    </a>
                    <a href="{{ route('teacher.assignments.create') }}" class="action-btn" style="background: #d1fae5; color: #065f46;">
                        <i class="fas fa-tasks"></i>
                        <span>Add Assignment</span>
                    </a>
                    <a href="{{ route('teacher.results.upload') }}" class="action-btn" style="background: #fef3c7; color: #92400e;">
                        <i class="fas fa-upload"></i>
                        <span>Upload Results</span>
                    </a>
                    <a href="{{ route('teacher.notices.create') }}" class="action-btn" style="background: #fee2e2; color: #991b1b;">
                        <i class="fas fa-bullhorn"></i>
                        <span>Post Notice</span>
                    </a>
                </div>
            </div>

            {{-- Pending Assignments --}}
            <div class="quick-actions mb-4">
                <div class="section-title" style="margin-bottom: 15px;">
                    <span><i class="fas fa-clock me-2" style="color: #ef4444;"></i> Pending Tasks</span>
                </div>
                @if(isset($pendingAssignments) && count($pendingAssignments) > 0)
                    @foreach($pendingAssignments as $assignment)
                        <div style="padding: 12px 0; border-bottom: 1px solid #e9ecef;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="font-weight: 600; font-size: 13px;">{{ $assignment->title }}</div>
                                    <div style="font-size: 11px; color: #6c757d;">Course: {{ $assignment->course->name }}</div>
                                </div>
                                <span style="font-size: 10px; background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 20px;">
                                    Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle text-success"></i>
                        <p class="text-muted small mt-2">No pending tasks!</p>
                    </div>
                @endif
            </div>

            {{-- Recent Notices --}}
            <div class="quick-actions mb-4">
                <div class="section-title" style="margin-bottom: 15px;">
                    <span><i class="fas fa-megaphone me-2" style="color: #10b981;"></i> Recent Notices</span>
                    <a href="{{ route('teacher.notices') }}" style="font-size: 11px; color: #667eea;">View All</a>
                </div>
                @if(isset($recentNotices) && count($recentNotices) > 0)
                    <div class="notice-list">
                        @foreach($recentNotices as $notice)
                            <div class="notice-item">
                                <div class="notice-title">{{ $notice->title }}</div>
                                <div class="notice-meta">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $notice->created_at->format('d M Y') }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-eye me-1"></i> {{ $notice->views ?? 0 }} views
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-bell-slash text-muted"></i>
                        <p class="text-muted small mt-2">No recent notices</p>
                    </div>
                @endif
            </div>

            {{-- Performance Summary --}}
            <div class="quick-actions">
                <div class="section-title" style="margin-bottom: 15px;">
                    <span><i class="fas fa-chart-line me-2" style="color: #667eea;"></i> Performance Summary</span>
                </div>
                <div style="margin-bottom: 15px;">
                    <div class="progress-label">
                        <span>Average Attendance</span>
                        <span>{{ $avgAttendance ?? 0 }}%</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 0%; background: #10b981;"></div>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <div class="progress-label">
                        <span>Assignments Graded</span>
                        <span>{{ $gradedPercentage ?? 0 }}%</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 0%; background: #f59e0b;"></div>
                    </div>
                </div>
                <div>
                    <div class="progress-label">
                        <span>Course Completion</span>
                        <span>{{ $courseCompletion ?? 0 }}%</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 0%; background: #667eea;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Animate progress bars on load
    window.addEventListener('load', function() {
        const progressBars = document.querySelectorAll('.progress-fill');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 200);
        });
    });
</script>

@endsection