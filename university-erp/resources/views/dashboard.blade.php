@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Welcome Banner -->

<div class="card border-0 shadow-lg mb-4"
     style="background:linear-gradient(135deg,#1a237e,#3949ab); border-radius:20px;">


<div class="card-body text-white p-4">

    <div class="row align-items-center">

        <div class="col-md-8">

            <h2 class="fw-bold mb-2">
                Welcome Back, {{ auth()->user()->name }} 👋
            </h2>

            <p class="mb-0 opacity-75">
                University ERP Management Dashboard
            </p>

        </div>

        <div class="col-md-4 text-end">

            <i class="bi bi-mortarboard-fill"
               style="font-size:90px; opacity:.25;"></i>

        </div>

    </div>

</div>


</div>

<!-- Statistics -->

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 row-cols-xxl-6 g-3 mb-4">


<!-- Students -->

<div class="col">

    <div class="stat-card p-4 text-white shadow-lg h-100"
         style="background:linear-gradient(135deg,#1565c0,#42a5f5); border-radius:18px;">

        <div class="d-flex justify-content-between">

            <div>
                <h2 class="fw-bold">{{ $stats['students'] }}</h2>
                <small>Total Students</small>
            </div>

            <i class="bi bi-people-fill fs-1"></i>

        </div>

    </div>

</div>

<!-- Teachers -->

<div class="col">

    <div class="stat-card p-4 text-white shadow-lg h-100"
         style="background:linear-gradient(135deg,#2e7d32,#66bb6a); border-radius:18px;">

        <div class="d-flex justify-content-between">

            <div>
                <h2 class="fw-bold">{{ $stats['teachers'] }}</h2>
                <small>Total Teachers</small>
            </div>

            <i class="bi bi-person-workspace fs-1"></i>

        </div>

    </div>

</div>

<!-- Courses -->

<div class="col">

    <div class="stat-card p-4 text-white shadow-lg h-100"
         style="background:linear-gradient(135deg,#ef6c00,#ff9800); border-radius:18px;">

        <div class="d-flex justify-content-between">

            <div>
                <h2 class="fw-bold">{{ $stats['courses'] }}</h2>
                <small>Courses</small>
            </div>

            <i class="bi bi-book-fill fs-1"></i>

        </div>

    </div>

</div>

<!-- Fees -->

<div class="col">

    <div class="stat-card p-4 text-white shadow-lg h-100"
         style="background:linear-gradient(135deg,#6a1b9a,#ab47bc); border-radius:18px;">

        <div class="d-flex justify-content-between">

            <div>
                <h5 class="fw-bold">
                    ৳{{ number_format($stats['fee_due']) }}
                </h5>
                <small>Fee Due</small>
            </div>

            <i class="bi bi-cash-stack fs-1"></i>

        </div>

    </div>

</div>

<!-- Results -->

<div class="col">

    <div class="stat-card p-4 text-white shadow-lg h-100"
         style="background:linear-gradient(135deg,#c2185b,#ec407a); border-radius:18px;">

        <div class="d-flex justify-content-between">

            <div>
                <h2 class="fw-bold">{{ $stats['results'] }}</h2>
                <small>Total Results</small>
            </div>

            <i class="bi bi-bar-chart-line-fill fs-1"></i>

        </div>

    </div>

</div>

<!-- Enrollments -->

<div class="col">

    <div class="stat-card p-4 text-white shadow-lg h-100"
         style="background:linear-gradient(135deg,#00897b,#26a69a); border-radius:18px;">

        <div class="d-flex justify-content-between">

            <div>
                <h2 class="fw-bold">{{ $stats['enrollments'] }}</h2>
                <small>Enrollments</small>
            </div>

            <i class="bi bi-journal-check fs-1"></i>

        </div>

    </div>

</div>


</div>

<!-- Quick Actions -->

<div class="card shadow-lg border-0 rounded-4 p-4 mb-4">


<h5 class="fw-bold mb-3">
    <i class="bi bi-lightning-charge-fill text-warning"></i>
    Quick Actions
</h5>

<div class="row g-3">

    <div class="col-md-3">
        <a href="{{ route('students.create') }}"
           class="btn btn-primary w-100 py-3">
           Add Student
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('teachers.create') }}"
           class="btn btn-success w-100 py-3">
           Add Teacher
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('courses.create') }}"
           class="btn btn-warning text-white w-100 py-3">
           Add Course
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('results.create') }}"
           class="btn btn-danger w-100 py-3">
           Add Result
        </a>
    </div>

</div>


</div>

<!-- Attendance + Notices -->

<div class="row g-4">


<div class="col-lg-4">

    <div class="card shadow-lg border-0 rounded-4 p-4 h-100">

        <h5 class="fw-bold mb-4">
            Today's Attendance
        </h5>

        <div class="row">

            <div class="col-6">

                <div class="text-center p-3 rounded bg-success bg-opacity-10">

                    <h2 class="text-success">
                        {{ $stats['today_present'] }}
                    </h2>

                    Present

                </div>

            </div>

            <div class="col-6">

                <div class="text-center p-3 rounded bg-danger bg-opacity-10">

                    <h2 class="text-danger">
                        {{ $stats['today_absent'] }}
                    </h2>

                    Absent

                </div>

            </div>

        </div>

    </div>

</div>

<div class="col-lg-8">

    <div class="card shadow-lg border-0 rounded-4 p-4 h-100">

        <h5 class="fw-bold mb-3">
            Recent Notices
        </h5>

        @forelse($recent_notices as $notice)

        <div class="border-bottom pb-3 mb-3">

            <div class="fw-bold">
                {{ $notice->title }}
            </div>

            <small class="text-muted">
                {{ \Carbon\Carbon::parse($notice->publish_date)->format('d M Y') }}
            </small>

        </div>

        @empty

        <p>No Notices Available</p>

        @endforelse

    </div>

</div>


</div>

<!-- Recent Results -->

<div class="card shadow-lg border-0 rounded-4 p-4 mt-4">


<h5 class="fw-bold mb-3">
    Recent Results
</h5>

<div class="table-responsive">

    <table class="table table-hover">

        <thead>

        <tr>

            <th>Student</th>
            <th>Course</th>
            <th>Total Marks</th>
            <th>Grade</th>
            <th>GPA</th>

        </tr>

        </thead>

        <tbody>

        @forelse($recent_results as $result)

        <tr>

            <td>{{ $result->student->name }}</td>

            <td>{{ $result->course->name }}</td>

            <td>{{ $result->total_marks }}</td>

            <td>
                <span class="badge bg-success rounded-pill px-3">
                    {{ $result->grade }}
                </span>
            </td>

            <td>
                <span class="badge bg-primary rounded-pill px-3">
                    {{ $result->gpa }}
                </span>
            </td>

        </tr>

        @empty

        <tr>
            <td colspan="5" class="text-center">
                No Results Available
            </td>
        </tr>

        @endforelse

        </tbody>

    </table>

</div>


</div>

@endsection
