@extends('layouts.student_app')

@section('title', 'My Enrolled Courses')

@section('content')

<style>
    .courses-wrapper {
        padding: 20px 0;
    }

    /* Header Section */
    .courses-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .courses-header::before {
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
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 12px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #2d3748;
    }

    .stat-label {
        font-size: 13px;
        color: #6c757d;
        margin-top: 5px;
    }

    /* Course Card */
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
        padding: 18px 22px;
        color: white;
        position: relative;
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

    .course-status {
        position: absolute;
        top: 18px;
        right: 22px;
        background: rgba(255,255,255,0.2);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .course-body {
        padding: 20px 22px;
    }

    .course-info {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
    }

    .info-item i {
        color: #667eea;
        width: 20px;
    }

    .info-item .label {
        color: #6c757d;
    }

    .info-item .value {
        font-weight: 600;
        color: #2d3748;
    }

    /* Progress Section */
    .progress-section {
        margin-bottom: 15px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-bottom: 6px;
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

    .progress-fill.attendance {
        background: linear-gradient(90deg, #10b981, #34d399);
    }

    .progress-fill.assignments {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }

    /* Instructor Info */
    .instructor-info {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 12px;
        margin-top: 15px;
    }

    .instructor-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }

    .instructor-details {
        flex: 1;
    }

    .instructor-name {
        font-size: 13px;
        font-weight: 600;
        color: #2d3748;
    }

    .instructor-title {
        font-size: 11px;
        color: #6c757d;
    }

    /* Action Buttons */
    .course-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-action {
        flex: 1;
        padding: 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102,126,234,0.4);
        color: white;
    }

    .btn-outline-custom {
        background: white;
        border: 1px solid #667eea;
        color: #667eea;
    }

    .btn-outline-custom:hover {
        background: #667eea;
        color: white;
    }

    /* Empty State */
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

    /* Pagination */
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

    /* Search and Filter */
    .filter-section {
        background: white;
        border-radius: 16px;
        padding: 15px 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .search-box {
        position: relative;
    }

    .search-box input {
        padding-left: 40px;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        height: 45px;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    @media (max-width: 768px) {
        .courses-header {
            padding: 20px;
        }
        .course-header {
            padding: 15px;
        }
        .course-title {
            font-size: 16px;
            padding-right: 70px;
        }
        .course-info {
            gap: 12px;
        }
        .info-item {
            font-size: 11px;
        }
    }
</style>

<div class="courses-wrapper">
    @php
        $totalCourses = $courses->count();
        $activeCourses = $courses->where('status', 'enrolled')->count();
        $completedCourses = $courses->where('status', 'completed')->count();
        $totalCredits = 0;
        foreach($courses as $enrollment) {
            $totalCredits += $enrollment->course->credit_hours ?? 3;
        }
        
        // Sample attendance data (replace with actual data from controller)
        $courseProgress = [];
        foreach($courses as $enrollment) {
            $courseProgress[$enrollment->course->id] = [
                'attendance' => rand(65, 95),
                'assignments' => rand(60, 100)
            ];
        }
    @endphp

    {{-- Header Section --}}
    <div class="courses-header">
        <div style="position: relative; z-index: 1;">
            <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                <i class="fas fa-book-open me-2"></i> My Enrolled Courses
            </h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                Track your courses, progress, and academic resources
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
                <div class="stat-value">{{ $totalCourses }}</div>
                <div class="stat-label">Total Courses</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(67,233,123,0.1);">
                    <i class="fas fa-play-circle" style="color: #43e97b; font-size: 28px;"></i>
                </div>
                <div class="stat-value">{{ $activeCourses }}</div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(250,112,154,0.1);">
                    <i class="fas fa-check-circle" style="color: #fa709a; font-size: 28px;"></i>
                </div>
                <div class="stat-value">{{ $completedCourses }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(255,193,7,0.1);">
                    <i class="fas fa-credit-card" style="color: #ffc107; font-size: 28px;"></i>
                </div>
                <div class="stat-value">{{ $totalCredits }}</div>
                <div class="stat-label">Total Credits</div>
            </div>
        </div>
    </div>

    {{-- Search and Filter --}}
    <div class="filter-section">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by course name or code...">
                </div>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-select" style="border-radius: 12px;">
                    <option value="">All Status</option>
                    <option value="enrolled">Enrolled</option>
                    <option value="completed">Completed</option>
                    <option value="dropped">Dropped</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="sortBy" class="form-select" style="border-radius: 12px;">
                    <option value="name">Sort by Name</option>
                    <option value="code">Sort by Code</option>
                    <option value="progress">Sort by Progress</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Courses Grid --}}
    <div id="coursesContainer">
        @forelse($courses as $enrollment)
            @php
                $course = $enrollment->course;
                $status = $enrollment->status;
                $statusBadge = match($status) {
                    'enrolled' => '🟢 Enrolled',
                    'completed' => '✅ Completed',
                    'dropped' => '⚠️ Dropped',
                    default => '📌 ' . ucfirst($status)
                };
                $attendanceRate = $courseProgress[$course->id]['attendance'] ?? rand(65, 95);
                $assignmentsRate = $courseProgress[$course->id]['assignments'] ?? rand(60, 100);
                $instructorName = $course->instructor->name ?? 'Dr. Sarah Johnson';
                $instructorInitial = strtoupper(substr($instructorName, 0, 1));
                $schedule = $course->schedule ?? 'Mon & Wed, 10:00 AM - 11:30 AM';
                $room = $course->room ?? 'Room 301, Academic Building';
            @endphp
            <div class="course-card" data-name="{{ strtolower($course->name) }}" data-code="{{ strtolower($course->code) }}" data-status="{{ $status }}">
                <div class="course-header">
                    <div class="course-code">{{ $course->code ?? 'N/A' }}</div>
                    <h4 class="course-title">{{ $course->name }}</h4>
                    <span class="course-status">{{ $statusBadge }}</span>
                </div>
                <div class="course-body">
                    <div class="course-info">
                        <div class="info-item">
                            <i class="fas fa-credit-card"></i>
                            <span class="label">Credits:</span>
                            <span class="value">{{ $course->credit_hours ?? 3 }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span class="label">Schedule:</span>
                            <span class="value">{{ $schedule }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-location-dot"></i>
                            <span class="label">Venue:</span>
                            <span class="value">{{ $room }}</span>
                        </div>
                    </div>

                    {{-- Progress Section --}}
                    <div class="progress-section">
                        <div class="progress-header">
                            <span><i class="fas fa-calendar-check"></i> Attendance</span>
                            <span>{{ $attendanceRate }}%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill attendance" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="progress-section">
                        <div class="progress-header">
                            <span><i class="fas fa-tasks"></i> Assignments</span>
                            <span>{{ $assignmentsRate }}%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill assignments" style="width: 0%"></div>
                        </div>
                    </div>

                    {{-- Instructor Info --}}
                    <div class="instructor-info">
                        <div class="instructor-avatar">{{ $instructorInitial }}</div>
                        <div class="instructor-details">
                            <div class="instructor-name">{{ $instructorName }}</div>
                            <div class="instructor-title">Course Instructor</div>
                        </div>
                        <a href="#" class="text-muted" style="font-size: 12px;">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="course-actions">
                        <a href="{{ route('student.course.details', $course->id) }}" class="btn-action btn-primary-custom">
                            <i class="fas fa-eye me-1"></i> View Details
                        </a>
                        <a href="{{ route('student.course.materials', $course->id) }}" class="btn-action btn-outline-custom">
                            <i class="fas fa-download me-1"></i> Materials
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h4>No Courses Enrolled</h4>
                <p class="text-muted">You haven't enrolled in any courses yet. Please contact the academic advisor.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($courses->hasPages())
        <div class="pagination-wrapper">
            {{ $courses->links() }}
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

    // Search and Filter Functionality
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const sortBy = document.getElementById('sortBy');
    const coursesContainer = document.getElementById('coursesContainer');
    let courses = Array.from(document.querySelectorAll('.course-card'));

    function filterAndSortCourses() {
        const searchTerm = searchInput?.value.toLowerCase() || '';
        const statusValue = statusFilter?.value || '';
        
        let filteredCourses = courses.filter(course => {
            const name = course.dataset.name || '';
            const code = course.dataset.code || '';
            const status = course.dataset.status || '';
            
            const matchesSearch = name.includes(searchTerm) || code.includes(searchTerm);
            const matchesStatus = !statusValue || status === statusValue;
            
            return matchesSearch && matchesStatus;
        });
        
        // Sort courses
        const sortValue = sortBy?.value || 'name';
        filteredCourses.sort((a, b) => {
            if (sortValue === 'name') {
                return (a.dataset.name || '').localeCompare(b.dataset.name || '');
            } else if (sortValue === 'code') {
                return (a.dataset.code || '').localeCompare(b.dataset.code || '');
            } else if (sortValue === 'progress') {
                const aProgress = parseInt(a.querySelector('.progress-fill.attendance')?.style.width) || 0;
                const bProgress = parseInt(b.querySelector('.progress-fill.attendance')?.style.width) || 0;
                return bProgress - aProgress;
            }
            return 0;
        });
        
        // Re-render courses
        if (coursesContainer) {
            filteredCourses.forEach(course => coursesContainer.appendChild(course));
        }
    }
    
    searchInput?.addEventListener('keyup', filterAndSortCourses);
    statusFilter?.addEventListener('change', filterAndSortCourses);
    sortBy?.addEventListener('change', filterAndSortCourses);
    
    // Store initial dataset values
    courses.forEach(course => {
        if (!course.dataset.name) {
            const title = course.querySelector('.course-title')?.textContent.toLowerCase() || '';
            const code = course.querySelector('.course-code')?.textContent.toLowerCase() || '';
            const statusElem = course.querySelector('.course-status');
            let status = '';
            if (statusElem) {
                const statusText = statusElem.textContent.toLowerCase();
                if (statusText.includes('enrolled')) status = 'enrolled';
                else if (statusText.includes('completed')) status = 'completed';
                else if (statusText.includes('dropped')) status = 'dropped';
            }
            course.dataset.name = title;
            course.dataset.code = code;
            course.dataset.status = status;
        }
    });
</script>

@endsection