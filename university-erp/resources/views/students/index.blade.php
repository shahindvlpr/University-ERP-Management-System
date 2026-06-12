@extends('layouts.app')

@section('title', 'Student Management')

@section('content')

<style>
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
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
        margin-bottom: 5px;
    }

    .stats-label {
        font-size: 13px;
        color: #6c757d;
    }

    .filter-section {
        background: white;
        border-radius: 16px;
        padding: 20px;
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

    .student-table {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .student-table .table {
        margin-bottom: 0;
    }

    .student-table .table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px;
        font-size: 13px;
        font-weight: 600;
        border: none;
    }

    .student-table .table tbody tr {
        transition: all 0.2s ease;
    }

    .student-table .table tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
    }

    .student-table .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #fef3c7;
        color: #92400e;
    }

    .status-graduated {
        background: #dbeafe;
        color: #1e40af;
    }

    .student-photo {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .btn-action {
        padding: 5px 12px;
        border-radius: 10px;
        font-size: 12px;
        margin: 2px;
        transition: all 0.2s;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-view {
        background: #e0e7ff;
        color: #4338ca;
    }

    .btn-view:hover {
        background: #4338ca;
        color: white;
    }

    .btn-edit {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-edit:hover {
        background: #d97706;
        color: white;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
    }

    .btn-add {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 10px 25px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102,126,234,0.4);
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

    @media (max-width: 768px) {
        .stats-number {
            font-size: 22px;
        }
        .student-table .table {
            font-size: 12px;
        }
        .btn-action {
            padding: 3px 8px;
            font-size: 10px;
        }
    }
</style>

<div>
    @php
        $totalStudents = $students->total();
        $activeStudents = $students->where('status', 'active')->count();
        $inactiveStudents = $students->where('status', 'inactive')->count();
        $graduatedStudents = $students->where('status', 'graduated')->count();
        $newThisMonth = $students->filter(function($student) {
            return $student->created_at >= now()->startOfMonth();
        })->count();
    @endphp

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(102,126,234,0.1);">
                    <i class="fas fa-users" style="color: #667eea; font-size: 28px;"></i>
                </div>
                <div class="stats-number">{{ $totalStudents }}</div>
                <div class="stats-label">Total Students</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(67,233,123,0.1);">
                    <i class="fas fa-user-check" style="color: #43e97b; font-size: 28px;"></i>
                </div>
                <div class="stats-number">{{ $activeStudents }}</div>
                <div class="stats-label">Active Students</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(250,112,154,0.1);">
                    <i class="fas fa-user-graduate" style="color: #fa709a; font-size: 28px;"></i>
                </div>
                <div class="stats-number">{{ $graduatedStudents }}</div>
                <div class="stats-label">Graduated</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(255,193,7,0.1);">
                    <i class="fas fa-calendar-plus" style="color: #ffc107; font-size: 28px;"></i>
                </div>
                <div class="stats-number">{{ $newThisMonth }}</div>
                <div class="stats-label">New This Month</div>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="filter-section">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by name, student ID, email, or phone..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-select" style="border-radius: 12px;">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="graduated" {{ request('status') == 'graduated' ? 'selected' : '' }}>Graduated</option>
                </select>
            </div>
            <div class="col-md-2">
                <select id="deptFilter" class="form-select" style="border-radius: 12px;">
                    <option value="">All Departments</option>
                    @foreach($departments ?? [] as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button id="resetFilters" class="btn btn-secondary w-100" style="border-radius: 12px;">
                    <i class="fas fa-undo-alt me-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    {{-- Action Bar --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="text-muted small">
                <i class="fas fa-info-circle"></i> Showing {{ $students->firstItem() ?? 0 }} - {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} students
            </span>
        </div>
        <div>
            @if(Route::has('students.export'))
                <button id="exportBtn" class="btn btn-success me-2" style="border-radius: 12px;">
                    <i class="fas fa-file-excel me-1"></i> Export
                </button>
            @endif
            <a href="{{ route('students.create') }}" class="btn btn-add text-white">
                <i class="fas fa-plus-circle me-1"></i> Add New Student
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px;">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Students Table --}}
    <div class="student-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th width="70">Photo</th>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Department</th>
                        <th>Email/Phone</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody id="studentsTableBody">
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($student->photo)
                                    <img src="{{ asset('storage/'.$student->photo) }}" class="student-photo" alt="{{ $student->name }}">
                                @else
                                    <img src="{{ asset('images/default-user.png') }}" class="student-photo" alt="{{ $student->name }}">
                                @endif
                            </td>
                            <td>
                                <strong>{{ $student->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $student->student_id }}</small>
                            </td>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->department->name ?? 'N/A' }}</td>
                            <td>
                                <small>
                                    <i class="fas fa-envelope"></i> {{ Str::limit($student->email, 20) }}<br>
                                    <i class="fas fa-phone"></i> {{ $student->phone ?? 'N/A' }}
                                </small>
                            </td>
                            <td>
                                @if($student->status == 'active')
                                    <span class="status-badge status-active">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Active
                                    </span>
                                @elseif($student->status == 'inactive')
                                    <span class="status-badge status-inactive">
                                        <i class="fas fa-pause me-1" style="font-size: 8px;"></i> Inactive
                                    </span>
                                @else
                                    <span class="status-badge status-graduated">
                                        <i class="fas fa-graduation-cap me-1"></i> Graduated
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small>
                                    <i class="fas fa-calendar-alt"></i> {{ $student->created_at->format('d M Y') }}<br>
                                    <i class="fas fa-clock"></i> {{ $student->created_at->diffForHumans() }}
                                </small>
                            </td>
                            <td>
                                <a href="{{ route('students.show', $student->id) }}" class="btn btn-action btn-view">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-action btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('students.destroy', $student->id) }}" style="display: inline-block;" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-action btn-delete">
                                        <i class="fas fa-trash"></i> Del
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-user-graduate"></i>
                                    <h4>No Students Found</h4>
                                    <p class="text-muted">Try adjusting your search or filter criteria, or add a new student.</p>
                                    <a href="{{ route('students.create') }}" class="btn btn-add text-white mt-2">
                                        <i class="fas fa-plus-circle me-1"></i> Add Your First Student
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($students->hasPages())
        <div class="pagination-wrapper">
            {{ $students->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<script>
    // Confirm delete
    function confirmDelete() {
        return confirm('⚠️ Are you sure you want to delete this student?\n\nThis action cannot be undone and will remove all associated records including enrollments, attendance, results, and fees.');
    }

    // Search and Filter
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const deptFilter = document.getElementById('deptFilter');
    const resetBtn = document.getElementById('resetFilters');
    const exportBtn = document.getElementById('exportBtn');

    function applyFilters() {
        let url = new URL(window.location.href);
        const search = searchInput?.value || '';
        const status = statusFilter?.value || '';
        const dept = deptFilter?.value || '';
        
        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');
        
        if (status) url.searchParams.set('status', status);
        else url.searchParams.delete('status');
        
        if (dept) url.searchParams.set('department', dept);
        else url.searchParams.delete('department');
        
        url.searchParams.set('page', '1');
        window.location.href = url.toString();
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            } else {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 500);
            }
        });
    }

    statusFilter?.addEventListener('change', applyFilters);
    deptFilter?.addEventListener('change', applyFilters);
    
    resetBtn?.addEventListener('click', function() {
        window.location.href = window.location.pathname;
    });
    
    // Only add export event listener if export button exists
    @if(Route::has('students.export'))
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                let url = '{{ route("students.export") }}?' + new URLSearchParams({
                    search: searchInput?.value || '',
                    status: statusFilter?.value || '',
                    department: deptFilter?.value || ''
                }).toString();
                window.location.href = url;
            });
        }
    @endif

    // Auto-dismiss alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) closeBtn.click();
        });
    }, 5000);
</script>

@endsection