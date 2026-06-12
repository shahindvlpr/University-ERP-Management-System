@extends('layouts.teacher_app')

@section('title', 'My Courses')

@section('content')

<style>
    .courses-wrapper {
        padding: 20px 0;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .course-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .course-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 25px;
        color: white;
    }

    .course-code {
        font-size: 12px;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .course-title {
        font-size: 18px;
        font-weight: 700;
        margin: 0;
    }

    .course-body {
        padding: 20px 25px;
    }

    .course-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 800;
        color: #2d3748;
    }

    .stat-label {
        font-size: 11px;
        color: #6c757d;
        margin-top: 5px;
    }

    .progress-section {
        margin-bottom: 20px;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-bottom: 8px;
    }

    .progress-bar-custom {
        height: 8px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 1s ease;
    }

    .btn-manage {
        width: 100%;
        padding: 10px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        background: #f8f9fa;
        color: #667eea;
        border: 1px solid #e9ecef;
        transition: all 0.3s;
        display: inline-block;
        text-decoration: none;
    }

    .btn-manage:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #667eea;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        color: white;
    }
</style>

<div class="courses-wrapper">
    {{-- Page Header --}}
    <div class="page-header">
        <div style="position: relative; z-index: 1;">
            <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                <i class="fas fa-book-open me-2"></i> My Courses
            </h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                Manage your courses, track progress, and view student performance
            </p>
        </div>
    </div>

    {{-- Courses Grid --}}
    @if($courses->count() > 0)
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-6 col-lg-4">
                    <div class="course-card">
                        <div class="course-header">
                            <div class="course-code">{{ $course->code ?? 'N/A' }}</div>
                            <h4 class="course-title">{{ $course->name }}</h4>
                        </div>
                        <div class="course-body">
                            <div class="course-stats">
                                <div class="stat-item">
                                    <div class="stat-value">{{ $course->total_students ?? $course->enrollments_count ?? 0 }}</div>
                                    <div class="stat-label">Students</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">{{ $course->attendance_rate ?? 0 }}%</div>
                                    <div class="stat-label">Attendance</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">{{ $course->assignments_count ?? 0 }}</div>
                                    <div class="stat-label">Assignments</div>
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
                            
                            <a href="{{ route('teacher.course.details', $course->id) }}" class="btn-manage">
                                <i class="fas fa-arrow-right me-1"></i> Manage Course
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($courses->hasPages())
            <div class="pagination-wrapper">
                {{ $courses->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="fas fa-book-open"></i>
            <h4>No Courses Assigned</h4>
            <p class="text-muted">You haven't been assigned any courses yet.</p>
        </div>
    @endif
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
            }, 100);
        });
    });
</script>

@endsection