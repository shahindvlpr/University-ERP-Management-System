@extends('layouts.app')

@section('title','Enrollment Details')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-info text-white">

        <h5 class="mb-0">
            <i class="bi bi-journal-check"></i>
            Enrollment Details
        </h5>

    </div>

    <div class="card-body">

        <table class="table">

            <tr>
                <th width="250">Student Name</th>
                <td>{{ $enrollment->student->name }}</td>
            </tr>

            <tr>
                <th>Student ID</th>
                <td>{{ $enrollment->student->student_id }}</td>
            </tr>

            <tr>
                <th>Course</th>
                <td>{{ $enrollment->course->name }}</td>
            </tr>

            <tr>
                <th>Course Code</th>
                <td>{{ $enrollment->course->code }}</td>
            </tr>

            <tr>
                <th>Session</th>
                <td>{{ $enrollment->session }}</td>
            </tr>

            <tr>
                <th>Semester</th>
                <td>{{ $enrollment->semester }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>

                    <span class="badge bg-success">
                        {{ ucfirst($enrollment->status) }}
                    </span>

                </td>
            </tr>

        </table>

        <a href="{{ route('enrollments.index') }}"
           class="btn btn-secondary">

            Back

        </a>

    </div>

</div>

@endsection