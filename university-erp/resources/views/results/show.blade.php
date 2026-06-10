@extends('layouts.app')

@section('title','Result Details')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-info text-white">

        Result Details

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th>Student</th>
                <td>{{ $result->student->name }}</td>
            </tr>

            <tr>
                <th>Course</th>
                <td>{{ $result->course->name }}</td>
            </tr>

            <tr>
                <th>Midterm Marks</th>
                <td>{{ $result->midterm_marks }}</td>
            </tr>

            <tr>
                <th>Final Marks</th>
                <td>{{ $result->final_marks }}</td>
            </tr>

            <tr>
                <th>Assignment Marks</th>
                <td>{{ $result->assignment_marks }}</td>
            </tr>

            <tr>
                <th>Total Marks</th>
                <td>{{ $result->total_marks }}</td>
            </tr>

            <tr>
                <th>Grade</th>
                <td>{{ $result->grade }}</td>
            </tr>

            <tr>
                <th>GPA</th>
                <td>{{ $result->gpa }}</td>
            </tr>

            <tr>
                <th>Session</th>
                <td>{{ $result->session }}</td>
            </tr>

            <tr>
                <th>Semester</th>
                <td>{{ $result->semester }}</td>
            </tr>

        </table>

        <a href="{{ route('results.index') }}"
           class="btn btn-secondary">

            Back

        </a>

    </div>

</div>

@endsection
