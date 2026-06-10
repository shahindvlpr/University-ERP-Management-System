@extends('layouts.app')

@section('title','Transcript')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-success text-white d-flex justify-content-between">

    <h5 class="mb-0">

        <i class="bi bi-award-fill"></i>

        Academic Transcript

    </h5>

    <button onclick="window.print()"
            class="btn btn-light btn-sm">

        <i class="bi bi-printer"></i>

        Print

    </button>

</div>

<div class="card-body">

    <div class="text-center mb-4">

        <h3 class="fw-bold">

            University ERP Management System

        </h3>

        <h5>

            Official Academic Transcript

        </h5>

    </div>

    <table class="table table-bordered">

        <tr>

            <th width="250">

                Student Name

            </th>

            <td>

                {{ $student->name }}

            </td>

        </tr>

        <tr>

            <th>

                Student ID

            </th>

            <td>

                {{ $student->student_id }}

            </td>

        </tr>

        <tr>

            <th>

                Department

            </th>

            <td>

                {{ $student->department->name ?? '-' }}

            </td>

        </tr>

        <tr>

            <th>

                Session

            </th>

            <td>

                {{ $student->session }}

            </td>

        </tr>

    </table>

    <h5 class="mt-4 mb-3">

        Course Results

    </h5>

    <table class="table table-bordered">

        <thead class="table-dark">

        <tr>

            <th>Course Code</th>
            <th>Course Name</th>
            <th>Credit</th>
            <th>Total Marks</th>
            <th>Grade</th>
            <th>GPA</th>

        </tr>

        </thead>

        <tbody>

        @forelse($results as $result)

        <tr>

            <td>

                {{ $result->course->code }}

            </td>

            <td>

                {{ $result->course->name }}

            </td>

            <td>

                {{ $result->course->credit_hours }}

            </td>

            <td>

                {{ $result->total_marks }}

            </td>

            <td>

                <span class="badge bg-success">

                    {{ $result->grade }}

                </span>

            </td>

            <td>

                {{ $result->gpa }}

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="6"
                class="text-center">

                No Result Available

            </td>

        </tr>

        @endforelse

        </tbody>

    </table>

    <div class="row mt-4">

        <div class="col-md-6">

            <div class="alert alert-info">

                <strong>

                    Total Credits:

                </strong>

                {{ $totalCredits }}

            </div>

        </div>

        <div class="col-md-6">

            <div class="alert alert-success">

                <strong>

                    CGPA:

                </strong>

                {{ $cgpa }}

            </div>

        </div>

    </div>

    <a href="{{ route('transcripts.index') }}"
       class="btn btn-secondary">

        Back

    </a>

</div>

</div>

@endsection