@extends('layouts.app')

@section('title', 'Teacher Management')

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

    .teacher-table {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .teacher-table .table {
        margin-bottom: 0;
    }

    .teacher-table .table thead th {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        color: white;
        padding: 15px;
        font-size: 13px;
        font-weight: 600;
        border: none;
    }

    .teacher-table .table tbody tr {
        transition: all 0.2s ease;
    }

    .teacher-table .table tbody tr:hover {
        background: #f8f9fa;
    }

    .teacher-table .table tbody td {
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
        background: #fee2e2;
        color: #991b1b;
    }

    .teacher-photo {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Action Buttons - Fixed Visibility */
    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
        cursor: pointer;
        gap: 4px;
    }

    .btn-action i {
        font-size: 12px;
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
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        border: none;
        padding: 10px 25px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(245,158,11,0.4);
        color: white;
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
        color: #f59e0b;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        border-color: transparent;
        color: white;
    }

    @media (max-width: 768px) {
        .stats-number {
            font-size: 22px;
        }
        .teacher-table .table {
            font-size: 12px;
        }
        .btn-action {
            padding: 4px 8px;
            font-size: 10px;
        }
        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<div>
    @php
        $totalTeachers = $teachers->total();
        $activeTeachers = $teachers->where('status', 'active')->count();
        $inactiveTeachers = $teachers->where('status', 'inactive')->count();
        $totalSalary = $teachers->sum('salary');
    @endphp

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(245,158,11,0.1);">
                    <i class="fas fa-chalkboard-user" style="color: #f59e0b; font-size: 28px;"></i>
                </div>
                <div class="stats-number">{{ $totalTeachers }}</div>
                <div class="stats-label">Total Teachers</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(16,185,129,0.1);">
                    <i class="fas fa-user-check" style="color: #10b981; font-size: 28px;"></i>
                </div>
                <div class="stats-number">{{ $activeTeachers }}</div>
                <div class="stats-label">Active Teachers</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(239,68,68,0.1);">
                    <i class="fas fa-user-clock" style="color: #ef4444; font-size: 28px;"></i>
                </div>
                <div class="stats-number">{{ $inactiveTeachers }}</div>
                <div class="stats-label">Inactive</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(255,193,7,0.1);">
                    <i class="fas fa-money-bill-wave" style="color: #ffc107; font-size: 28px;"></i>
                </div>
                <div class="stats-number">৳{{ number_format($totalSalary / 1000, 1) }}K</div>
                <div class="stats-label">Total Salary/Month</div>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="filter-section">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by name, teacher ID, email, or phone..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-select" style="border-radius: 12px;">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="deptFilter" class="form-select" style="border-radius: 12px;">
                    <option value="">All Departments</option>
                    @foreach($departments ?? [] as $dept)
                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Action Bar --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="text-muted small">
                <i class="fas fa-info-circle"></i> Showing {{ $teachers->firstItem() ?? 0 }} - {{ $teachers->lastItem() ?? 0 }} of {{ $teachers->total() }} teachers
            </span>
        </div>
        <div>
            <a href="{{ route('teachers.create') }}" class="btn-add">
                <i class="fas fa-plus-circle"></i> Add New Teacher
            </a>
        </div>
    </div>

    {{-- Success/Error Messages --}}
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

    {{-- Teachers Table --}}
    <div class="teacher-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th width="60">Photo</th>
                        <th>Teacher ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Contact</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($teacher->photo)
                                    <img src="{{ asset('storage/'.$teacher->photo) }}" class="teacher-photo" alt="{{ $teacher->name }}">
                                @else
                                    <img src="{{ asset('images/default-user.png') }}" class="teacher-photo" alt="{{ $teacher->name }}">
                                @endif
                            </td>
                            <td><strong>{{ $teacher->teacher_id }}</strong></td>
                            <td>
                                <strong>{{ $teacher->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $teacher->email }}</small>
                            </td>
                            <td>{{ $teacher->department->name ?? 'N/A' }}</td>
                            <td>{{ $teacher->designation ?? 'N/A' }}</td>
                            <td>
                                <small>
                                    <i class="fas fa-phone"></i> {{ $teacher->phone ?? 'N/A' }}
                                </small>
                            </td>
                            <td>
                                <strong class="text-success">৳{{ number_format($teacher->salary, 0) }}</strong>
                            </td>
                            <td>
                                @if($teacher->status == 'active')
                                    <span class="status-badge status-active">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Active
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('teachers.show', $teacher->id) }}" class="btn-action btn-view" title="View Teacher">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn-action btn-edit" title="Edit Teacher">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('teachers.destroy', $teacher->id) }}" style="display: inline-block;" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Delete Teacher">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <i class="fas fa-chalkboard-user"></i>
                                    <h4>No Teachers Found</h4>
                                    <p class="text-muted">Try adjusting your search or filter criteria, or add a new teacher.</p>
                                    <a href="{{ route('teachers.create') }}" class="btn-add mt-2">
                                        <i class="fas fa-plus-circle"></i> Add Your First Teacher
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
    @if($teachers->hasPages())
        <div class="pagination-wrapper">
            {{ $teachers->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<script>
    // Confirm delete
    function confirmDelete() {
        return confirm('⚠️ Are you sure you want to delete this teacher?\n\nThis action cannot be undone and will remove all associated records including courses, assignments, and salary information.');
    }

    // Search and Filter
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const deptFilter = document.getElementById('deptFilter');

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