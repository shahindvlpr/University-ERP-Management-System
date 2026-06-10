@extends('layouts.app')

@section('title','Course Details')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-book"></i>
            Course Details
        </h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="25%">Course Code</th>
                <td>{{ $course->code }}</td>
            </tr>

            <tr>
                <th>Course Name</th>
                <td>{{ $course->name }}</td>
            </tr>

            <tr>
                <th>Department</th>
                <td>{{ $course->department->name ?? '' }}</td>
            </tr>

            <tr>
                <th>Teacher</th>
                <td>{{ $course->teacher->name ?? '' }}</td>
            </tr>

            <tr>
                <th>Credit Hours</th>
                <td>{{ $course->credit_hours }}</td>
            </tr>

            <tr>
                <th>Semester</th>
                <td>{{ $course->semester }}</td>
            </tr>

            <tr>
                <th>Description</th>
                <td>{{ $course->description }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    @if($course->status=='active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
            </tr>

        </table>

        <a href="{{ route('courses.index') }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Back

        </a>

        <a href="{{ route('courses.edit',$course->id) }}"
           class="btn btn-warning">

            <i class="bi bi-pencil"></i>
            Edit

        </a>

    </div>

</div>

@endsection

