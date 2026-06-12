@extends('layouts.teacher_app')

@section('title', 'My Profile')

@section('content')

<style>
    .profile-wrapper {
        padding: 20px 0;
    }

    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        object-fit: cover;
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .profile-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 25px;
        color: white;
    }

    .profile-card-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .info-row {
        display: flex;
        padding: 15px 25px;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.2s;
    }

    .info-row:hover {
        background: #f8f9fa;
    }

    .info-label {
        width: 140px;
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
    }

    .info-value {
        flex: 1;
        font-size: 14px;
        color: #2d3748;
        font-weight: 500;
    }

    .edit-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .edit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102,126,234,0.4);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-box {
        background: white;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }

    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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

    .stat-number {
        font-size: 28px;
        font-weight: 800;
        color: #2d3748;
    }

    .stat-label {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }

    .modal-content-custom {
        border-radius: 20px;
        overflow: hidden;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    .form-control-custom {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
    }

    .form-control-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
    }

    @media (max-width: 768px) {
        .info-row {
            flex-direction: column;
            gap: 8px;
        }
        .info-label {
            width: 100%;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="profile-wrapper">
    {{-- Profile Header --}}
    <div class="profile-header">
        <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 25px; flex-wrap: wrap;">
            <div>
                @if($teacher->photo)
                    <img src="{{ asset('storage/'.$teacher->photo) }}" class="profile-avatar" alt="{{ $teacher->name }}">
                @else
                    <div class="profile-avatar" style="background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 48px; color: white;">
                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div>
                <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 5px;">
                    {{ $teacher->name }}
                </h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                    <i class="fas fa-id-card me-2"></i> {{ $teacher->teacher_id }}
                </p>
                <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 5px 0 0;">
                    <i class="fas fa-envelope me-2"></i> {{ $teacher->email }}
                </p>
            </div>
        </div>
    </div>

    {{-- Statistics Grid --}}
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(102,126,234,0.1);">
                <i class="fas fa-book" style="color: #667eea;"></i>
            </div>
            <div class="stat-number">{{ $totalCourses ?? 0 }}</div>
            <div class="stat-label">Courses Teaching</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(16,185,129,0.1);">
                <i class="fas fa-users" style="color: #10b981;"></i>
            </div>
            <div class="stat-number">{{ $totalStudents ?? 0 }}</div>
            <div class="stat-label">Total Students</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(245,158,11,0.1);">
                <i class="fas fa-clock" style="color: #f59e0b;"></i>
            </div>
            <div class="stat-number">{{ $totalClasses ?? 0 }}</div>
            <div class="stat-label">Classes This Week</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(239,68,68,0.1);">
                <i class="fas fa-calendar-check" style="color: #ef4444;"></i>
            </div>
            <div class="stat-number">{{ $todayClasses ?? 0 }}</div>
            <div class="stat-label">Today's Classes</div>
        </div>
    </div>

    {{-- Profile Information Card --}}
    <div class="profile-card">
        <div class="profile-card-header">
            <h4><i class="fas fa-user-circle me-2"></i> Personal Information</h4>
        </div>
        
        <div class="info-row">
            <div class="info-label"><i class="fas fa-user me-2"></i> Full Name</div>
            <div class="info-value">{{ $teacher->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label"><i class="fas fa-id-badge me-2"></i> Teacher ID</div>
            <div class="info-value">{{ $teacher->teacher_id }}</div>
        </div>
        <div class="info-row">
            <div class="info-label"><i class="fas fa-envelope me-2"></i> Email Address</div>
            <div class="info-value">{{ $teacher->email }}</div>
        </div>
        <div class="info-row">
            <div class="info-label"><i class="fas fa-phone me-2"></i> Phone Number</div>
            <div class="info-value">{{ $teacher->phone ?? 'Not provided' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label"><i class="fas fa-calendar me-2"></i> Date of Birth</div>
            <div class="info-value">{{ $teacher->dob ? \Carbon\Carbon::parse($teacher->dob)->format('d M Y') : 'Not provided' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label"><i class="fas fa-venus-mars me-2"></i> Gender</div>
            <div class="info-value">{{ ucfirst($teacher->gender ?? 'Not specified') }}</div>
        </div>
    </div>

    {{-- Professional Information Card --}}
    <div class="profile-card">
        <div class="profile-card-header">
            <h4><i class="fas fa-briefcase me-2"></i> Professional Information</h4>
        </div>
        
        <div class="info-row">
            <div class="info-label"><i class="fas fa-building me-2"></i> Department</div>
            <div class="info-value">{{ $teacher->department->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label"><i class="fas fa-user-tag me-2"></i> Designation</div>
            <div class="info-value">{{ $teacher->designation ?? 'Not specified' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label"><i class="fas fa-graduation-cap me-2"></i> Qualification</div>
            <div class="info-value">{{ $teacher->qualification ?? 'Not provided' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label"><i class="fas fa-calendar-alt me-2"></i> Joining Date</div>
            <div class="info-value">{{ $teacher->joining_date ? \Carbon\Carbon::parse($teacher->joining_date)->format('d M Y') : 'Not provided' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label"><i class="fas fa-map-marker-alt me-2"></i> Address</div>
            <div class="info-value">{{ $teacher->address ?? 'Not provided' }}</div>
        </div>
    </div>

    {{-- Bio Section --}}
    @if($teacher->bio)
    <div class="profile-card">
        <div class="profile-card-header">
            <h4><i class="fas fa-file-alt me-2"></i> Bio / About Me</h4>
        </div>
        <div class="info-row">
            <div class="info-value" style="line-height: 1.6;">
                {{ $teacher->bio }}
            </div>
        </div>
    </div>
    @endif

    {{-- Edit Profile Button --}}
    <div class="text-center mt-3">
        <button class="btn edit-btn text-white" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="fas fa-edit me-2"></i> Edit Profile
        </button>
    </div>
</div>

{{-- Edit Profile Modal --}}
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i> Edit Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('teacher.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-custom" value="{{ $teacher->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-custom" value="{{ $teacher->email }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control form-control-custom" value="{{ $teacher->phone }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control form-control-custom" value="{{ $teacher->dob }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select form-control-custom">
                                <option value="">Select Gender</option>
                                <option value="male" {{ $teacher->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $teacher->gender == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ $teacher->gender == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation" class="form-control form-control-custom" value="{{ $teacher->designation }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="qualification" class="form-control form-control-custom" value="{{ $teacher->qualification }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Joining Date</label>
                            <input type="date" name="joining_date" class="form-control form-control-custom" value="{{ $teacher->joining_date }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="photo" class="form-control form-control-custom" accept="image/*">
                            <small class="text-muted">Leave empty to keep current photo</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control form-control-custom" rows="2">{{ $teacher->address }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Bio / About Me</label>
                            <textarea name="bio" class="form-control form-control-custom" rows="4">{{ $teacher->bio }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection