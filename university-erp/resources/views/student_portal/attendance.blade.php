@extends('layouts.student_app')

@section('title', 'My Attendance Record')

@section('content')

<style>
    .attendance-wrapper {
        padding: 20px 0;
    }

    /* Header Section */
    .attendance-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .attendance-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* Summary Cards */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 15px;
    }

    .stat-label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #2d3748;
    }

    .stat-sub {
        font-size: 12px;
        margin-top: 5px;
    }

    /* Progress Circle */
    .progress-circle-container {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        text-align: center;
    }

    .circular-progress {
        position: relative;
        width: 180px;
        height: 180px;
        margin: 0 auto 20px;
    }

    .circular-progress svg {
        transform: rotate(-90deg);
    }

    .circular-progress circle {
        fill: none;
        stroke-width: 12;
    }

    .circular-progress .bg-circle {
        stroke: #e9ecef;
    }

    .circular-progress .progress-circle {
        stroke: url(#gradient);
        stroke-dasharray: 502;
        stroke-dashoffset: 502;
        transition: stroke-dashoffset 1.5s ease;
    }

    .progress-percentage {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .progress-percentage .value {
        font-size: 36px;
        font-weight: 800;
        color: #667eea;
    }

    .progress-percentage .label {
        font-size: 12px;
        color: #6c757d;
    }

    /* Course-wise Attendance */
    .course-card {
        background: white;
        border-radius: 16px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .course-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .course-name {
        font-size: 15px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .course-code {
        font-size: 11px;
        color: #6c757d;
        margin-left: 8px;
    }

    .progress {
        height: 8px;
        border-radius: 10px;
        margin: 10px 0;
    }

    /* Calendar View */
    .calendar-container {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .calendar-nav {
        display: flex;
        gap: 10px;
    }

    .calendar-nav button {
        background: #f8f9fa;
        border: none;
        padding: 8px 15px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .calendar-nav button:hover {
        background: #667eea;
        color: white;
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        text-align: center;
        margin-bottom: 10px;
    }

    .calendar-weekdays div {
        padding: 10px;
        font-weight: 600;
        font-size: 12px;
        color: #6c757d;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px 5px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8f9fa;
        font-size: 13px;
        position: relative;
    }

    .calendar-day:hover {
        background: #e9ecef;
        transform: scale(1.05);
    }

    .calendar-day.present {
        background: #d1fae5;
        color: #065f46;
    }

    .calendar-day.absent {
        background: #fee2e2;
        color: #991b1b;
    }

    .calendar-day.late {
        background: #fef3c7;
        color: #92400e;
    }

    .calendar-day.today {
        border: 2px solid #667eea;
        font-weight: bold;
    }

    .calendar-day .day-date {
        font-weight: 600;
    }

    .calendar-day .day-status {
        font-size: 9px;
        margin-top: 3px;
    }

    /* Attendance Table */
    .attendance-table {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .attendance-table .table {
        margin-bottom: 0;
    }

    .attendance-table .table thead th {
        background: #f8f9fa;
        padding: 15px;
        font-size: 13px;
        font-weight: 700;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .attendance-table .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        font-size: 14px;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
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

    .filter-section {
        background: white;
        border-radius: 16px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
        background: white;
        border-radius: 0 0 20px 20px;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #667eea;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
    }

    @media (max-width: 768px) {
        .calendar-day {
            font-size: 10px;
            padding: 5px;
        }
        .calendar-weekdays div {
            font-size: 10px;
        }
        .stat-value {
            font-size: 22px;
        }
    }
</style>

<div class="attendance-wrapper">
    @php
        $totalDays = $attendances->count();
        $presentDays = $attendances->where('status', 'present')->count();
        $absentDays = $attendances->where('status', 'absent')->count();
        $lateDays = $attendances->where('status', 'late')->count();
        $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;
        
        // Course-wise attendance
        $courseAttendance = [];
        foreach($attendances as $attendance) {
            $courseName = $attendance->course->name ?? 'Unknown';
            if (!isset($courseAttendance[$courseName])) {
                $courseAttendance[$courseName] = ['present' => 0, 'total' => 0, 'code' => $attendance->course->code ?? ''];
            }
            $courseAttendance[$courseName]['total']++;
            if ($attendance->status == 'present') {
                $courseAttendance[$courseName]['present']++;
            }
        }
        
        $requiredRate = 75; // Minimum required attendance percentage
        $isGoodStanding = $attendanceRate >= $requiredRate;
        $remainingNeeded = 0;
        if (!$isGoodStanding && $totalDays > 0) {
            $totalNeeded = ceil(($requiredRate * $totalDays - $presentDays * 100) / (100 - $requiredRate));
            $remainingNeeded = max(0, $totalNeeded);
        }
    @endphp

    {{-- Header Section --}}
    <div class="attendance-header">
        <div style="position: relative; z-index: 1;">
            <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                <i class="fas fa-calendar-check me-2"></i> My Attendance Record
            </h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                Track your daily attendance and maintain academic standing
            </p>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(102,126,234,0.1); color: #667eea;">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-label">Total Classes</div>
                <div class="stat-value">{{ $totalDays }}</div>
                <div class="stat-sub text-muted">Current Semester</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(67,233,123,0.1); color: #43e97b;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-label">Present</div>
                <div class="stat-value">{{ $presentDays }}</div>
                <div class="stat-sub text-success">days attended</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(250,112,154,0.1); color: #fa709a;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-label">Absent</div>
                <div class="stat-value">{{ $absentDays }}</div>
                <div class="stat-sub text-danger">days missed</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(255,193,7,0.1); color: #ffc107;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-label">Late</div>
                <div class="stat-value">{{ $lateDays }}</div>
                <div class="stat-sub text-warning">days late</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column --}}
        <div class="col-lg-5">
            {{-- Circular Progress --}}
            <div class="progress-circle-container">
                <svg width="0" height="0">
                    <defs>
                        <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
                <div class="circular-progress">
                    <svg width="180" height="180" viewBox="0 0 180 180">
                        <circle class="bg-circle" cx="90" cy="90" r="80" stroke="#e9ecef" fill="none" stroke-width="12" />
                        <circle class="progress-circle" id="progressCircle" cx="90" cy="90" r="80" stroke="url(#gradient)" fill="none" stroke-width="12" stroke-linecap="round" />
                    </svg>
                    <div class="progress-percentage">
                        <div class="value" id="attendancePercentage">{{ $attendanceRate }}%</div>
                        <div class="label">Attendance Rate</div>
                    </div>
                </div>
                @if($isGoodStanding)
                    <div class="alert alert-success mt-3 mb-0" style="border-radius: 12px;">
                        <i class="fas fa-thumbs-up me-2"></i> Great! Your attendance is above the required {{ $requiredRate }}%
                    </div>
                @else
                    <div class="alert alert-warning mt-3 mb-0" style="border-radius: 12px;">
                        <i class="fas fa-exclamation-triangle me-2"></i> 
                        Need {{ $remainingNeeded }} more consecutive presents to reach {{ $requiredRate }}%
                    </div>
                @endif
            </div>

            {{-- Course-wise Attendance --}}
            <div class="calendar-container">
                <h5 class="mb-3" style="font-size: 16px; font-weight: 700;">
                    <i class="fas fa-book me-2" style="color: #667eea;"></i> Course-wise Attendance
                </h5>
                @forelse($courseAttendance as $courseName => $data)
                    @php
                        $courseRate = $data['total'] > 0 ? round(($data['present'] / $data['total']) * 100) : 0;
                        $barColor = $courseRate >= 75 ? '#10b981' : ($courseRate >= 60 ? '#f59e0b' : '#ef4444');
                    @endphp
                    <div class="course-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="course-name">{{ $courseName }}</span>
                                <span class="course-code">{{ $data['code'] }}</span>
                            </div>
                            <span style="font-weight: 700; color: {{ $barColor }};">{{ $courseRate }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $courseRate }}%; background: {{ $barColor }};"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Present: {{ $data['present'] }}</span>
                            <span>Total: {{ $data['total'] }}</span>
                            <span>Absent: {{ $data['total'] - $data['present'] }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-chart-line fa-2x mb-2"></i>
                        <p>No attendance data available</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Right Column --}}
        <div class="col-lg-7">
            {{-- Calendar View --}}
            <div class="calendar-container">
                <div class="calendar-header">
                    <h5 class="mb-0" style="font-size: 16px; font-weight: 700;">
                        <i class="fas fa-calendar me-2" style="color: #667eea;"></i>
                        <span id="currentMonthYear"></span>
                    </h5>
                    <div class="calendar-nav">
                        <button onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i></button>
                        <button onclick="changeMonth(1)"><i class="fas fa-chevron-right"></i></button>
                        <button onclick="goToToday()">Today</button>
                    </div>
                </div>
                <div class="calendar-weekdays">
                    <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                </div>
                <div id="calendarDays" class="calendar-days"></div>
            </div>

            {{-- Filter Section --}}
            <div class="filter-section">
                <div class="row g-3">
                    <div class="col-md-5">
                        <select id="courseFilter" class="form-select form-select-sm" style="border-radius: 10px;">
                            <option value="">All Courses</option>
                            @foreach($courseAttendance as $courseName => $data)
                                <option value="{{ $courseName }}">{{ $courseName }} ({{ $data['code'] }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select id="statusFilter" class="form-select form-select-sm" style="border-radius: 10px;">
                            <option value="">All Status</option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="late">Late</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="dateSearch" class="form-control form-control-sm" placeholder="Search by date..." style="border-radius: 10px;">
                    </div>
                </div>
            </div>

            {{-- Attendance Table --}}
            <div class="attendance-table">
                <div class="table-responsive">
                    <table class="table" id="attendanceTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Course</th>
                                <th>Day</th>
                                <th>Status</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                @php
                                    $statusClass = match($attendance->status) {
                                        'present' => 'status-present',
                                        'absent' => 'status-absent',
                                        'late' => 'status-late',
                                        default => ''
                                    };
                                    $statusIcon = match($attendance->status) {
                                        'present' => '✅',
                                        'absent' => '❌',
                                        'late' => '⏰',
                                        default => '📌'
                                    };
                                    $dayName = \Carbon\Carbon::parse($attendance->date)->format('l');
                                @endphp
                                <tr data-course="{{ $attendance->course->name ?? '' }}" data-status="{{ $attendance->status }}" data-date="{{ $attendance->date }}">
                                    <td><strong>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</strong></td>
                                    <td>{{ $attendance->course->name ?? 'N/A' }}</td>
                                    <td>{{ $dayName }}</td>
                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $statusIcon }} {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($attendance->status == 'late')
                                            <small class="text-warning">Arrived late</small>
                                        @elseif($attendance->status == 'absent')
                                            <small class="text-danger">Marked absent</small>
                                        @else
                                            <small class="text-success">Present on time</small>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
                                        No attendance records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($attendances->hasPages())
                    <div class="pagination-wrapper">
                        {{ $attendances->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Circular Progress Animation
    window.addEventListener('load', function() {
        const percentage = {{ $attendanceRate }};
        const circumference = 2 * Math.PI * 80;
        const dashArray = circumference;
        const dashOffset = circumference - (percentage / 100) * circumference;
        
        const progressCircle = document.getElementById('progressCircle');
        if (progressCircle) {
            setTimeout(() => {
                progressCircle.style.strokeDasharray = dashArray;
                progressCircle.style.strokeDashoffset = dashOffset;
            }, 100);
        }
    });

    // Table Filtering
    function filterTable() {
        const courseFilter = document.getElementById('courseFilter').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const dateSearch = document.getElementById('dateSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#attendanceTable tbody tr');
        
        rows.forEach(row => {
            if (row.cells.length < 5) return;
            
            const course = row.cells[1]?.textContent.toLowerCase() || '';
            const status = row.cells[3]?.textContent.toLowerCase() || '';
            const date = row.cells[0]?.textContent.toLowerCase() || '';
            
            let show = true;
            if (courseFilter && !course.includes(courseFilter)) show = false;
            if (statusFilter && !status.includes(statusFilter)) show = false;
            if (dateSearch && !date.includes(dateSearch)) show = false;
            
            row.style.display = show ? '' : 'none';
        });
    }
    
    document.getElementById('courseFilter')?.addEventListener('change', filterTable);
    document.getElementById('statusFilter')?.addEventListener('change', filterTable);
    document.getElementById('dateSearch')?.addEventListener('keyup', filterTable);
    
    // Calendar View
    let currentDate = new Date();
    const attendanceDates = @json($attendances->groupBy(function($item) {
        return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
    })->map(function($items) {
        return $items->first()->status;
    })->toArray());
    
    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDayOfWeek = firstDay.getDay();
        const daysInMonth = lastDay.getDate();
        
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        document.getElementById('currentMonthYear').innerHTML = `${monthNames[month]} ${year}`;
        
        const calendarDays = document.getElementById('calendarDays');
        calendarDays.innerHTML = '';
        
        for (let i = 0; i < startDayOfWeek; i++) {
            const emptyDiv = document.createElement('div');
            emptyDiv.className = 'calendar-day';
            emptyDiv.style.background = 'transparent';
            emptyDiv.style.cursor = 'default';
            calendarDays.appendChild(emptyDiv);
        }
        
        const today = new Date();
        const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
        
        for (let day = 1; day <= daysInMonth; day++) {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const status = attendanceDates[dateStr];
            
            const dayDiv = document.createElement('div');
            dayDiv.className = 'calendar-day';
            
            if (status) {
                dayDiv.classList.add(status);
            }
            if (dateStr === todayStr) {
                dayDiv.classList.add('today');
            }
            
            dayDiv.innerHTML = `
                <div class="day-date">${day}</div>
                ${status ? `<div class="day-status">${status === 'present' ? '✅' : (status === 'absent' ? '❌' : '⏰')}</div>` : '<div class="day-status" style="opacity:0.3;">—</div>'}
            `;
            dayDiv.onclick = () => {
                document.getElementById('dateSearch').value = dateStr;
                filterTable();
            };
            calendarDays.appendChild(dayDiv);
        }
    }
    
    function changeMonth(delta) {
        currentDate.setMonth(currentDate.getMonth() + delta);
        renderCalendar();
    }
    
    function goToToday() {
        currentDate = new Date();
        renderCalendar();
        document.getElementById('dateSearch').value = '';
        filterTable();
    }
    
    renderCalendar();
</script>

@endsection