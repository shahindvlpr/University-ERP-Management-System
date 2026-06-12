@extends('layouts.teacher_app')

@section('title', 'Attendance Management')

@section('content')

<style>
    .attendance-wrapper {
        padding: 20px 0;
    }

    .page-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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

    .course-selector {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .view-toggle {
        background: white;
        border-radius: 20px;
        padding: 15px 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .toggle-buttons {
        display: flex;
        gap: 10px;
        background: #f1f5f9;
        padding: 5px;
        border-radius: 40px;
    }

    .toggle-btn {
        padding: 8px 25px;
        border-radius: 30px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        background: transparent;
    }

    .toggle-btn.active {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(16,185,129,0.3);
    }

    .date-navigator {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #f8f9fa;
        padding: 8px 15px;
        border-radius: 40px;
    }

    .date-nav-btn {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 8px 15px;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .date-nav-btn:hover {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }

    .previous-attendance {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .section-title {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 2px solid #e9ecef;
        font-weight: 700;
        color: #2d3748;
    }

    .student-list {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .student-table {
        margin-bottom: 0;
    }

    .student-table thead th {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }

    .student-photo {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .attendance-options {
        display: flex;
        gap: 10px;
    }

    .attendance-btn {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .attendance-btn.present {
        background: #d1fae5;
        color: #065f46;
    }

    .attendance-btn.present:hover,
    .attendance-btn.present.active {
        background: #10b981;
        color: white;
    }

    .attendance-btn.absent {
        background: #fee2e2;
        color: #991b1b;
    }

    .attendance-btn.absent:hover,
    .attendance-btn.absent.active {
        background: #ef4444;
        color: white;
    }

    .attendance-btn.late {
        background: #fef3c7;
        color: #92400e;
    }

    .attendance-btn.late:hover,
    .attendance-btn.late.active {
        background: #f59e0b;
        color: white;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .status-present {
        background: #d1fae5;
        color: #065f46;
    }

    .status-absent {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-late {
        background: #fef3c7;
        color: #92400e;
    }

    .submit-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        margin-top: 20px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16,185,129,0.4);
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

    .attendance-summary {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 15px;
        flex: 1;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .summary-number {
        font-size: 28px;
        font-weight: 800;
    }

    .summary-label {
        font-size: 12px;
        color: #6c757d;
    }
</style>

<div class="attendance-wrapper">
    {{-- Page Header --}}
    <div class="page-header">
        <div style="position: relative; z-index: 1;">
            <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                <i class="fas fa-calendar-check me-2"></i> Attendance Management
            </h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                Select a course and mark attendance for students
            </p>
        </div>
    </div>

    {{-- Course Selector --}}
    <div class="course-selector">
        <form method="GET" action="{{ route('teacher.attendance') }}" id="courseForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Select Course</label>
                    <select name="course_id" class="form-select" onchange="document.getElementById('courseForm').submit()" style="border-radius: 12px;">
                        <option value="">-- Select a Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }} ({{ $course->code }}) - {{ $course->enrollments_count ?? 0 }} students
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    @if($selectedCourse)
        {{-- View Mode Toggle --}}
        <div class="view-toggle">
            <div class="toggle-buttons">
                <button class="toggle-btn {{ $viewMode == 'mark' ? 'active' : '' }}" onclick="setViewMode('mark')">
                    <i class="fas fa-pen me-1"></i> Mark Attendance
                </button>
                <button class="toggle-btn {{ $viewMode == 'view' ? 'active' : '' }}" onclick="setViewMode('view')">
                    <i class="fas fa-chart-line me-1"></i> View Records
                </button>
            </div>
            
            @if($viewMode == 'mark')
                <div class="date-navigator">
                    <button class="date-nav-btn" onclick="changeDate(-1)">
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <input type="date" id="datePicker" class="form-control" style="width: auto; border-radius: 30px;" value="{{ $selectedDate }}">
                    <button class="date-nav-btn" onclick="changeDate(1)">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            @endif
        </div>

        {{-- Attendance Summary --}}
        @if($viewMode == 'view')
            <div class="previous-attendance">
                <div class="section-title">
                    <i class="fas fa-chart-pie me-2"></i> Attendance Summary - {{ $selectedCourse->name }}
                </div>
                <div class="p-3">
                    <div class="attendance-summary">
                        <div class="summary-card">
                            <div class="summary-number" style="color: #10b981;">{{ $totalClasses ?? 0 }}</div>
                            <div class="summary-label">Total Classes</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-number" style="color: #3b82f6;">{{ $totalStudents ?? 0 }}</div>
                            <div class="summary-label">Total Students</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-number" style="color: #f59e0b;">{{ round($overallAttendanceRate ?? 0, 1) }}%</div>
                            <div class="summary-label">Overall Attendance Rate</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Date Selector for Previous Records --}}
        @if($viewMode == 'view')
            <div class="course-selector">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Select Date to View</label>
                        <input type="date" id="historyDatePicker" class="form-control" value="{{ $selectedDate }}" style="border-radius: 12px;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">&nbsp;</label>
                        <button class="btn btn-primary w-100" onclick="loadHistory()" style="border-radius: 12px;">
                            <i class="fas fa-search me-1"></i> View Records
                        </button>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">&nbsp;</label>
                        <div class="date-navigator" style="justify-content: flex-end;">
                            <button class="date-nav-btn" onclick="changeHistoryDate(-1)">Previous Day</button>
                            <button class="date-nav-btn" onclick="changeHistoryDate(1)">Next Day</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Mark Attendance Mode --}}
        @if($viewMode == 'mark')
            <div class="student-list">
                <form method="POST" action="{{ route('teacher.attendance.mark') }}" id="attendanceForm">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">
                    <input type="hidden" name="date" value="{{ $selectedDate }}">
                    
                    <div class="table-responsive">
                        <table class="table student-table">
                            <thead>
                                <tr>
                                    <th width="50">#</th>
                                    <th width="60">Photo</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Previous Status</th>
                                    <th width="280">Mark Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $index => $enrollment)
                                    @php
                                        $student = $enrollment->student;
                                        $attendance = isset($attendances[$student->id]) ? $attendances[$student->id] : null;
                                        $prevStatus = $attendance ? $attendance->status : '';
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($student && $student->photo)
                                                <img src="{{ asset('storage/'.$student->photo) }}" class="student-photo">
                                            @else
                                                <img src="{{ asset('images/default-user.png') }}" class="student-photo">
                                            @endif
                                        </td>
                                        <td><strong>{{ $student->student_id ?? 'N/A' }}</strong></td>
                                        <td>{{ $student->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($prevStatus)
                                                <span class="status-badge status-{{ $prevStatus }}">
                                                    {{ ucfirst($prevStatus) }}
                                                </span>
                                            @else
                                                <span class="text-muted">No record</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="attendance-options">
                                                <button type="button" class="attendance-btn present {{ $prevStatus == 'present' ? 'active' : '' }}" onclick="setAttendance(this, 'present', {{ $student->id }})">
                                                    <i class="fas fa-check-circle"></i> Present
                                                </button>
                                                <button type="button" class="attendance-btn absent {{ $prevStatus == 'absent' ? 'active' : '' }}" onclick="setAttendance(this, 'absent', {{ $student->id }})">
                                                    <i class="fas fa-times-circle"></i> Absent
                                                </button>
                                                <button type="button" class="attendance-btn late {{ $prevStatus == 'late' ? 'active' : '' }}" onclick="setAttendance(this, 'late', {{ $student->id }})">
                                                    <i class="fas fa-clock"></i> Late
                                                </button>
                                            </div>
                                            <input type="hidden" name="attendance[{{ $student->id }}]" id="attendance_{{ $student->id }}" value="{{ $prevStatus }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-users"></i>
                                                <h4>No Students Enrolled</h4>
                                                <p class="text-muted">No students are enrolled in this course yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($students->count() > 0)
                        <div class="text-center p-4">
                            <button type="submit" class="btn submit-btn text-white">
                                <i class="fas fa-save me-2"></i> Save Attendance
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        @endif

        {{-- View Records Mode --}}
        @if($viewMode == 'view')
            <div class="student-list" id="historyContainer">
                <div class="table-responsive">
                    <table class="table student-table">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th width="60">Photo</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Attendance Status</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            @forelse($students as $index => $enrollment)
                                @php
                                    $student = $enrollment->student;
                                    $attendance = isset($attendances[$student->id]) ? $attendances[$student->id] : null;
                                    $status = $attendance ? $attendance->status : 'Not Marked';
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($student && $student->photo)
                                            <img src="{{ asset('storage/'.$student->photo) }}" class="student-photo">
                                        @else
                                            <img src="{{ asset('images/default-user.png') }}" class="student-photo">
                                        @endif
                                    </td>
                                    <td><strong>{{ $student->student_id ?? 'N/A' }}</strong></td>
                                    <td>{{ $student->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($status == 'present')
                                            <span class="status-badge status-present">✓ Present</span>
                                        @elseif($status == 'absent')
                                            <span class="status-badge status-absent">✗ Absent</span>
                                        @elseif($status == 'late')
                                            <span class="status-badge status-late">⏰ Late</span>
                                        @else
                                            <span class="text-muted">— Not Marked —</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($status == 'late')
                                            <small>Student arrived late to class</small>
                                        @elseif($status == 'absent')
                                            <small class="text-danger">Absent without notice</small>
                                        @elseif($status == 'present')
                                            <small class="text-success">Present on time</small>
                                        @else
                                            <small class="text-muted">No attendance recorded</small>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-times"></i>
                                            <h4>No Attendance Records</h4>
                                            <p class="text-muted">No attendance records found for {{ $selectedDate }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @else
        <div class="empty-state" style="background: white; border-radius: 20px; padding: 60px;">
            <i class="fas fa-book-open"></i>
            <h4>Select a Course</h4>
            <p class="text-muted">Please select a course from the dropdown above to manage attendance.</p>
        </div>
    @endif
</div>

<script>
    let currentViewMode = '{{ $viewMode }}';
    let selectedCourseId = '{{ $selectedCourse ? $selectedCourse->id : '' }}';
    
    function setViewMode(mode) {
        const url = new URL(window.location.href);
        url.searchParams.set('view_mode', mode);
        if (selectedCourseId) {
            url.searchParams.set('course_id', selectedCourseId);
        }
        if (mode === 'mark') {
            const datePicker = document.getElementById('datePicker');
            if (datePicker && datePicker.value) {
                url.searchParams.set('date', datePicker.value);
            }
        } else {
            const historyDatePicker = document.getElementById('historyDatePicker');
            if (historyDatePicker && historyDatePicker.value) {
                url.searchParams.set('date', historyDatePicker.value);
            }
        }
        window.location.href = url.toString();
    }
    
    function changeDate(delta) {
        const datePicker = document.getElementById('datePicker');
        if (!datePicker) return;
        
        let date = new Date(datePicker.value);
        date.setDate(date.getDate() + delta);
        const formattedDate = date.toISOString().split('T')[0];
        datePicker.value = formattedDate;
        
        const url = new URL(window.location.href);
        url.searchParams.set('date', formattedDate);
        if (selectedCourseId) {
            url.searchParams.set('course_id', selectedCourseId);
        }
        url.searchParams.set('view_mode', 'mark');
        window.location.href = url.toString();
    }
    
    function changeHistoryDate(delta) {
        const datePicker = document.getElementById('historyDatePicker');
        if (!datePicker) return;
        
        let date = new Date(datePicker.value);
        date.setDate(date.getDate() + delta);
        const formattedDate = date.toISOString().split('T')[0];
        datePicker.value = formattedDate;
        loadHistory();
    }
    
    function loadHistory() {
        const datePicker = document.getElementById('historyDatePicker');
        if (!datePicker) return;
        
        const date = datePicker.value;
        const url = new URL(window.location.href);
        url.searchParams.set('date', date);
        if (selectedCourseId) {
            url.searchParams.set('course_id', selectedCourseId);
        }
        url.searchParams.set('view_mode', 'view');
        window.location.href = url.toString();
    }
    
    function setAttendance(button, status, studentId) {
        const parentDiv = button.parentElement;
        const buttons = parentDiv.querySelectorAll('.attendance-btn');
        buttons.forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
        const attendanceInput = document.getElementById(`attendance_${studentId}`);
        if (attendanceInput) {
            attendanceInput.value = status;
        }
    }
    
    // Auto-submit when date picker changes
    document.addEventListener('DOMContentLoaded', function() {
        const datePicker = document.getElementById('datePicker');
        if (datePicker) {
            datePicker.addEventListener('change', function() {
                if (this.value) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('date', this.value);
                    if (selectedCourseId) {
                        url.searchParams.set('course_id', selectedCourseId);
                    }
                    url.searchParams.set('view_mode', 'mark');
                    window.location.href = url.toString();
                }
            });
        }
        
        const historyDatePicker = document.getElementById('historyDatePicker');
        if (historyDatePicker) {
            historyDatePicker.addEventListener('change', loadHistory);
        }
    });
</script>

@endsection