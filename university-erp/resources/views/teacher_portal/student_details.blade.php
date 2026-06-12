@extends('layouts.teacher_app')

@section('title', 'Student Details')

@section('content')

<style>
    .student-details-wrapper {
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

    .profile-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        text-align: center;
        color: white;
        position: relative;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid white;
        margin: 0 auto 15px;
        object-fit: cover;
        background: white;
    }

    .profile-name {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .profile-id {
        font-size: 14px;
        opacity: 0.9;
    }

    .info-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .info-title {
        font-size: 16px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }

    .info-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-label {
        width: 120px;
        font-size: 13px;
        color: #6c757d;
        font-weight: 500;
    }

    .info-value {
        flex: 1;
        font-size: 13px;
        color: #2d3748;
        font-weight: 500;
    }

    .course-badge {
        background: #e0e7ff;
        color: #4338ca;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        margin: 3px;
    }

    .attendance-table, .results-table {
        width: 100%;
        border-collapse: collapse;
    }

    .attendance-table th, .results-table th {
        background: #f8f9fa;
        padding: 12px;
        font-size: 12px;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .attendance-table td, .results-table td {
        padding: 10px;
        font-size: 13px;
        border-bottom: 1px solid #e9ecef;
    }

    .status-present {
        background: #d1fae5;
        color: #065f46;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .status-absent {
        background: #fee2e2;
        color: #991b1b;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .status-late {
        background: #fef3c7;
        color: #92400e;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .grade-badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .grade-A-plus, .grade-A { background: #d1fae5; color: #065f46; }
    .grade-B-plus, .grade-B { background: #dbeafe; color: #1e40af; }
    .grade-C { background: #fef3c7; color: #92400e; }
    .grade-F { background: #fee2e2; color: #991b1b; }

    .btn-back {
        background: #6c757d;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #5a6268;
        color: white;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #cbd5e0;
    }
</style>

<div class="student-details-wrapper">
    {{-- Page Header --}}
    <div class="page-header">
        <div style="position: relative; z-index: 1;">
            <a href="{{ route('teacher.students') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Students
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Left Column - Profile --}}
        <div class="col-lg-4">
            <div class="profile-card">
                <div class="profile-header">
                    @if($student->photo)
                        <img src="{{ asset('storage/'.$student->photo) }}" class="profile-avatar" alt="{{ $student->name }}">
                    @else
                        <div class="profile-avatar" style="background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 48px;">
                            {{ strtoupper(substr($student->name, 0, 1)) }}
                        </div>
                    @endif
                    <h3 class="profile-name">{{ $student->name }}</h3>
                    <p class="profile-id">{{ $student->student_id }}</p>
                </div>
                <div class="info-card">
                    <h5 class="info-title">
                        <i class="fas fa-user-circle me-2"></i> Personal Information
                    </h5>
                    <div class="info-row">
                        <div class="info-label">Student ID</div>
                        <div class="info-value">{{ $student->student_id }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $student->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $student->phone ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Gender</div>
                        <div class="info-value">{{ ucfirst($student->gender ?? 'N/A') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Department</div>
                        <div class="info-value">{{ $student->department->name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Session</div>
                        <div class="info-value">{{ $student->session ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Semester</div>
                        <div class="info-value">{{ $student->semester ?? 'N/A' }}th</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="col-lg-8">
            {{-- Enrolled Courses --}}
            <div class="info-card">
                <h5 class="info-title">
                    <i class="fas fa-book-open me-2"></i> Enrolled Courses
                </h5>
                @if($enrollments->count() > 0)
                    <div>
                        @foreach($enrollments as $enrollment)
                            <span class="course-badge">
                                {{ $enrollment->course->name ?? 'N/A' }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-book"></i>
                        <p>No courses enrolled</p>
                    </div>
                @endif
            </div>

            {{-- Recent Attendance --}}
            <div class="info-card">
                <h5 class="info-title">
                    <i class="fas fa-calendar-check me-2"></i> Recent Attendance
                </h5>
                @if($attendance->count() > 0)
                    <div class="table-responsive">
                        <table class="attendance-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendance as $record)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                                        <td>{{ $record->course->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($record->status == 'present')
                                                <span class="status-present">✓ Present</span>
                                            @elseif($record->status == 'absent')
                                                <span class="status-absent">✗ Absent</span>
                                            @else
                                                <span class="status-late">⏰ Late</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>No attendance records found</p>
                    </div>
                @endif
            </div>

            {{-- Results --}}
            <div class="info-card">
                <h5 class="info-title">
                    <i class="fas fa-chart-line me-2"></i> Academic Results
                </h5>
                @if($results->count() > 0)
                    <div class="table-responsive">
                        <table class="results-table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Exam Name</th>
                                    <th>Marks</th>
                                    <th>Grade</th>
                                    <th>GPA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $result)
                                    @php
                                        $gradeClass = match($result->grade) {
                                            'A+', 'A' => 'grade-A-plus',
                                            'B+', 'B' => 'grade-B-plus',
                                            'C' => 'grade-C',
                                            default => 'grade-F'
                                        };
                                    @endphp
                                    <tr>
                                        <td>{{ $result->course->name ?? 'N/A' }}</td>
                                        <td>{{ $result->exam_name ?? 'Regular' }}</td>
                                        <td>{{ $result->marks ?? 'N/A' }}</td>
                                        <td>
                                            <span class="grade-badge {{ $gradeClass }}">
                                                {{ $result->grade ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($result->gpa ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-line"></i>
                        <p>No results published yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection