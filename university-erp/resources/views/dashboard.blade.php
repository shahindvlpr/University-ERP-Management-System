@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">
            <i class="bi bi-speedometer2"></i>
            Dashboard Overview
        </h3>
        <small class="text-muted">
            Welcome back, {{ auth()->user()->name }}
        </small>
    </div>
</div>

<!-- Statistics Cards -->

<div class="row g-4 mb-4">


<div class="col-lg-3 col-md-6">
    <div class="stat-card p-4 text-white"
         style="background:linear-gradient(135deg,#1565c0,#42a5f5);">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h2 class="fw-bold mb-0">
                    {{ $stats['students'] }}
                </h2>
                <small>Total Students</small>
            </div>

            <i class="bi bi-people-fill fs-1"></i>

        </div>

    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="stat-card p-4 text-white"
         style="background:linear-gradient(135deg,#2e7d32,#66bb6a);">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h2 class="fw-bold mb-0">
                    {{ $stats['teachers'] }}
                </h2>
                <small>Total Teachers</small>
            </div>

            <i class="bi bi-person-workspace fs-1"></i>

        </div>

    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="stat-card p-4 text-white"
         style="background:linear-gradient(135deg,#ef6c00,#ff9800);">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h2 class="fw-bold mb-0">
                    {{ $stats['courses'] }}
                </h2>
                <small>Active Courses</small>
            </div>

            <i class="bi bi-book-half fs-1"></i>

        </div>

    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="stat-card p-4 text-white"
         style="background:linear-gradient(135deg,#6a1b9a,#ab47bc);">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h2 class="fw-bold mb-0">
                    ৳{{ number_format($stats['fee_due']) }}
                </h2>
                <small>Fee Due</small>
            </div>

            <i class="bi bi-cash-stack fs-1"></i>

        </div>

    </div>
</div>


</div>

<!-- Quick Actions -->

<div class="card p-4 mb-4">


<h5 class="fw-bold mb-3">
    <i class="bi bi-lightning-charge-fill text-warning"></i>
    Quick Actions
</h5>

<div class="row g-3">

    <div class="col-md-3">
        <a href="{{ route('students.create') }}"
           class="btn btn-primary w-100">
            <i class="bi bi-person-plus-fill"></i>
            Add Student
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('departments.create') }}"
           class="btn btn-success w-100">
            <i class="bi bi-building-add"></i>
            Add Department
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('students.index') }}"
           class="btn btn-info w-100 text-white">
            <i class="bi bi-people-fill"></i>
            View Students
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('reports.index') }}"
           class="btn btn-dark w-100">
            <i class="bi bi-file-earmark-bar-graph"></i>
            Reports
        </a>
    </div>

</div>


</div>

<div class="row g-4">


<!-- Attendance -->
<div class="col-lg-4">

    <div class="card p-4 h-100">

        <h5 class="fw-bold mb-3">
            <i class="bi bi-calendar-check"></i>
            Today's Attendance
        </h5>

        <div class="row">

            <div class="col-6">

                <div class="text-center p-3 rounded bg-success bg-opacity-10">

                    <h2 class="text-success fw-bold">
                        {{ $stats['today_present'] }}
                    </h2>

                    <small>Present</small>

                </div>

            </div>

            <div class="col-6">

                <div class="text-center p-3 rounded bg-danger bg-opacity-10">

                    <h2 class="text-danger fw-bold">
                        {{ $stats['today_absent'] }}
                    </h2>

                    <small>Absent</small>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Notices -->
<div class="col-lg-8">

    <div class="card p-4 h-100">

        <h5 class="fw-bold mb-3">
            <i class="bi bi-megaphone-fill"></i>
            Recent Notices
        </h5>

        @forelse($recent_notices as $notice)

            <div class="border-bottom pb-2 mb-2">

                <div class="fw-semibold">
                    {{ $notice->title }}
                </div>

                <small class="text-muted">
                    {{ $notice->publish_date->format('d M Y') }}
                </small>

            </div>

        @empty

            <p class="text-muted mb-0">
                No notices available.
            </p>

        @endforelse

    </div>

</div>


</div>

@endsection
