@extends('layouts.app')

@section('title', 'Teacher Profile')

@section('content')

<div class="row">

    <div class="col-md-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                @if($teacher->photo)

                <img src="{{ asset('storage/'.$teacher->photo) }}"
                     width="180"
                     height="180"
                     class="rounded-circle border shadow mb-3">

                @else

                <img src="https://via.placeholder.com/180"
                     class="rounded-circle border shadow mb-3">

                @endif

                <h4>{{ $teacher->name }}</h4>

                <p class="text-muted">
                    {{ $teacher->designation }}
                </p>

                <span class="badge bg-success">
                    {{ ucfirst($teacher->status) }}
                </span>

            </div>

        </div>

    </div>

    <div class="col-md-8">

        <div class="card shadow-sm">

            <div class="card-header bg-primary text-white">
                Teacher Information
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th>Teacher ID</th>
                        <td>{{ $teacher->teacher_id }}</td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td>{{ $teacher->name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $teacher->email }}</td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td>{{ $teacher->phone }}</td>
                    </tr>

                    <tr>
                        <th>Department</th>
                        <td>{{ $teacher->department->name ?? '' }}</td>
                    </tr>

                    <tr>
                        <th>Designation</th>
                        <td>{{ $teacher->designation }}</td>
                    </tr>

                    <tr>
                        <th>Specialization</th>
                        <td>{{ $teacher->specialization }}</td>
                    </tr>

                    <tr>
                        <th>Joining Date</th>
                        <td>{{ $teacher->joining_date }}</td>
                    </tr>

                    <tr>
                        <th>Salary</th>
                        <td>৳{{ number_format($teacher->salary) }}</td>
                    </tr>

                </table>

                <a href="{{ route('teachers.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>

                <a href="{{ route('teachers.edit',$teacher->id) }}"
                   class="btn btn-warning">
                    Edit
                </a>

            </div>

        </div>

    </div>

</div>

@endsection