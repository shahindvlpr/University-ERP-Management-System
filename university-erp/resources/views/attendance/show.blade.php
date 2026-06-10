@extends('layouts.app')

@section('title','Attendance Details')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            Attendance Details
        </h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="25%">Student</th>
                <td>{{ $attendance->student->name }}</td>
            </tr>

            <tr>
                <th>Course</th>
                <td>{{ $attendance->course->name }}</td>
            </tr>

            <tr>
                <th>Date</th>
                <td>{{ $attendance->date->format('d M Y') }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>

                    @if($attendance->status=='present')
                        <span class="badge bg-success">Present</span>
                    @elseif($attendance->status=='late')
                        <span class="badge bg-warning">Late</span>
                    @else
                        <span class="badge bg-danger">Absent</span>
                    @endif

                </td>
            </tr>

            <tr>
                <th>Remarks</th>
                <td>{{ $attendance->remarks }}</td>
            </tr>

        </table>

        <a href="{{ route('attendance.index') }}"
           class="btn btn-secondary">

            Back

        </a>

        <a href="{{ route('attendance.edit',$attendance->id) }}"
           class="btn btn-warning">

            Edit

        </a>

    </div>

</div>

@endsection