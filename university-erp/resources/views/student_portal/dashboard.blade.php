@extends('layouts.app')

@section('title','Student Dashboard')

@section('content')

<div class="container-fluid">

    <!-- Welcome Section -->

    <div class="card border-0 shadow-lg mb-4"
         style="background: linear-gradient(135deg,#4f46e5,#7c3aed); border-radius:20px;">

        <div class="card-body p-5 text-white">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h2 class="fw-bold mb-2">
                        Welcome Back,
                        {{ $student->name }}
                        👋
                    </h2>

                    <p class="mb-0 fs-5">
                        Student Dashboard
                    </p>

                    <small>
                        Manage your academic information,
                        results, attendance and fees.
                    </small>

                </div>

                <div class="col-md-4 text-end">

                    <i class="bi bi-mortarboard-fill"
                       style="font-size:90px;opacity:.3;">
                    </i>

                </div>

            </div>

        </div>

    </div>

    <!-- Statistics -->

    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="card border-0 shadow h-100"
                 style="border-radius:18px;">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h2 class="fw-bold text-primary">
                                {{ $courseCount }}
                            </h2>

                            <p class="text-muted mb-0">
                                Courses
                            </p>

                        </div>

                        <i class="bi bi-book-fill text-primary"
                           style="font-size:45px;">
                        </i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow h-100"
                 style="border-radius:18px;">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h2 class="fw-bold text-success">
                                {{ $attendanceCount }}
                            </h2>

                            <p class="text-muted mb-0">
                                Attendance
                            </p>

                        </div>

                        <i class="bi bi-calendar-check-fill text-success"
                           style="font-size:45px;">
                        </i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow h-100"
                 style="border-radius:18px;">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h2 class="fw-bold text-warning">
                                {{ $resultCount }}
                            </h2>

                            <p class="text-muted mb-0">
                                Results
                            </p>

                        </div>

                        <i class="bi bi-bar-chart-fill text-warning"
                           style="font-size:45px;">
                        </i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow h-100"
                 style="border-radius:18px;">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h2 class="fw-bold text-danger">
                                ৳{{ number_format($feeDue) }}
                            </h2>

                            <p class="text-muted mb-0">
                                Fee Due
                            </p>

                        </div>

                        <i class="bi bi-cash-stack text-danger"
                           style="font-size:45px;">
                        </i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Student Profile -->

    <div class="row">

        <div class="col-lg-4">

            <div class="card border-0 shadow-lg"
                 style="border-radius:20px;">

                <div class="card-body text-center">

                    <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=4f46e5&color=fff&size=200"
                         class="rounded-circle mb-3"
                         width="130">

                    <h4 class="fw-bold">

                        {{ $student->name }}

                    </h4>

                    <p class="text-muted">

                        {{ $student->student_id }}

                    </p>

                    <hr>

                    <div class="text-start">

                        <p>

                            <strong>Email:</strong><br>

                            {{ $student->email }}

                        </p>

                        <p>

                            <strong>Department:</strong><br>

                            {{ $student->department->name }}

                        </p>

                        <p>

                            <strong>Semester:</strong><br>

                            {{ $student->semester }}

                        </p>

                        <p>

                            <strong>Status:</strong><br>

                            <span class="badge bg-success">
                                Active
                            </span>

                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- Quick Links -->

        <div class="col-lg-8">

            <div class="card border-0 shadow-lg"
                 style="border-radius:20px;">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-lightning-charge-fill text-warning"></i>

                        Quick Access

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <a href="{{ route('student.courses') }}"
                               class="btn btn-primary w-100 py-3">

                                <i class="bi bi-book-fill"></i>

                                My Courses

                            </a>

                        </div>

                        <div class="col-md-6">

                            <a href="{{ route('student.attendance') }}"
                               class="btn btn-success w-100 py-3">

                                <i class="bi bi-calendar-check-fill"></i>

                                Attendance

                            </a>

                        </div>

                        <div class="col-md-6">

                            <a href="{{ route('student.results') }}"
                               class="btn btn-warning w-100 py-3 text-dark">

                                <i class="bi bi-bar-chart-fill"></i>

                                Results

                            </a>

                        </div>

                        <div class="col-md-6">

                            <a href="{{ route('student.fees') }}"
                               class="btn btn-danger w-100 py-3">

                                <i class="bi bi-cash-stack"></i>

                                Fee Status

                            </a>

                        </div>

                        <div class="col-md-12">

                            <a href="{{ route('student.transcript') }}"
                               class="btn btn-dark w-100 py-3">

                                <i class="bi bi-file-earmark-pdf-fill"></i>

                                Academic Transcript

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection