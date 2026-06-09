@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#1565c0,#1976d2)">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1 opacity-75 small">Total Students</p>
                    <h2 class="mb-0 fw-bold">{{ $stats['students'] }}</h2>
                </div>
                <span style="font-size:2rem">👨‍🎓</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#2e7d32,#388e3c)">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1 opacity-75 small">Total Teachers</p>
                    <h2 class="mb-0 fw-bold">{{ $stats['teachers'] }}</h2>
                </div>
                <span style="font-size:2rem">👨‍🏫</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#e65100,#f57c00)">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1 opacity-75 small">Active Courses</p>
                    <h2 class="mb-0 fw-bold">{{ $stats['courses'] }}</h2>
                </div>
                <span style="font-size:2rem">📚</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#6a1b9a,#7b1fa2)">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1 opacity-75 small">Fee Due (৳)</p>
                    <h2 class="mb-0 fw-bold">{{ number_format($stats['fee_due']) }}</h2>
                </div>
                <span style="font-size:2rem">💰</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Today's Attendance</h6>
            <div class="d-flex gap-3">
                <div class="text-center flex-fill p-3 rounded-3 bg-success bg-opacity-10">
                    <h3 class="text-success fw-bold mb-0">{{ $stats['today_present'] }}</h3>
                    <small class="text-muted">Present</small>
                </div>
                <div class="text-center flex-fill p-3 rounded-3 bg-danger bg-opacity-10">
                    <h3 class="text-danger fw-bold mb-0">{{ $stats['today_absent'] }}</h3>
                    <small class="text-muted">Absent</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Recent Notices</h6>
            @forelse($recent_notices as $notice)
            <div class="d-flex align-items-start gap-2 mb-2 pb-2 border-bottom">
                <span class="badge bg-{{ $notice->category == 'exam' ? 'danger' : ($notice->category == 'event' ? 'success' : 'primary') }}">{{ ucfirst($notice->category) }}</span>
                <div>
                    <div class="fw-semibold small">{{ $notice->title }}</div>
                    <small class="text-muted">{{ $notice->publish_date->format('d M Y') }}</small>
                </div>
            </div>
            @empty
            <p class="text-muted mb-0">No notices yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection