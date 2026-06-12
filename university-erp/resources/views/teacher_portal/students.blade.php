@extends('layouts.teacher_app')

@section('title', 'My Students')

@section('content')

<style>
    .students-wrapper {
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

    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .stats-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 12px;
    }

    .stats-number {
        font-size: 28px;
        font-weight: 800;
        color: #2d3748;
    }

    .stats-label {
        font-size: 13px;
        color: #6c757d;
        margin-top: 5px;
    }

    .student-table-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .student-table {
        margin-bottom: 0;
    }

    .student-table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px;
        font-size: 13px;
        font-weight: 600;
        border: none;
    }

    .student-table tbody tr {
        transition: all 0.2s ease;
    }

    .student-table tbody tr:hover {
        background: #f8f9fa;
    }

    .student-table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }

    .student-photo {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .course-badge {
        background: #e0e7ff;
        color: #4338ca;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .btn-view {
        background: #e0e7ff;
        color: #4338ca;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-view:hover {
        background: #4338ca;
        color: white;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .pagination-wrapper {
        padding: 20px;
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

<div class="students-wrapper">
    {{-- Page Header --}}
    <div class="page-header">
        <div style="position: relative; z-index: 1;">
            <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                <i class="fas fa-users me-2"></i> My Students
            </h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                View and manage students enrolled in your courses
            </p>
        </div>
    </div>

    {{-- Statistics --}}
    @php
        $totalStudents = $students->count();
        $uniqueStudents = $students->unique('student_id')->count();
        $totalCourses = $students->unique('course_id')->count();
    @endphp

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(102,126,234,0.1);">
                    <i class="fas fa-user-graduate" style="color: #667eea; font-size: 28px;"></i>
                </div>
                <div class="stats-number">{{ $uniqueStudents }}</div>
                <div class="stats-label">Total Students</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(16,185,129,0.1);">
                    <i class="fas fa-book" style="color: #10b981; font-size: 28px;"></i>
                </div>
                <div class="stats-number">{{ $totalCourses }}</div>
                <div class="stats-label">Courses</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(245,158,11,0.1);">
                    <i class="fas fa-calendar-check" style="color: #f59e0b; font-size: 28px;"></i>
                </div>
                <div class="stats-number">{{ $totalStudents }}</div>
                <div class="stats-label">Total Enrollments</div>
            </div>
        </div>
    </div>

    {{-- Students Table --}}
    <div class="student-table-container">
        <div class="table-responsive">
            <table class="table student-table">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th width="70">Photo</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Enrolled Date</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $enrollment)
                        @php
                            $student = $enrollment->student;
                            $course = $enrollment->course;
                        @endphp
                        <tr>
                            <td>{{ $students->firstItem() + $index }}</td>
                            <td>
                                @if($student && $student->photo)
                                    <img src="{{ asset('storage/'.$student->photo) }}" class="student-photo" alt="{{ $student->name }}">
                                @else
                                    <img src="{{ asset('images/default-user.png') }}" class="student-photo" alt="{{ $student->name ?? 'Student' }}">
                                @endif
                            </td>
                            <td><strong>{{ $student->student_id ?? 'N/A' }}</strong></td>
                            <td>
                                <strong>{{ $student->name ?? 'N/A' }}</strong>
                            </td>
                            <td>{{ $student->email ?? 'N/A' }}</td>
                            <td>
                                <span class="course-badge">{{ $course->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($enrollment->created_at)->format('d M Y') }}
                            </td>
                            <td>
                                <a href="{{ route('teacher.student.details', $student->id) }}" class="btn-view">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-user-graduate"></i>
                                    <h4>No Students Found</h4>
                                    <p class="text-muted">No students are enrolled in your courses yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($students->hasPages())
            <div class="pagination-wrapper">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>

@endsection