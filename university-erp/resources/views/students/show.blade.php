```php
@extends('layouts.app')

@section('title', 'Student Details')

@section('content')

<div class="row">

    <!-- Profile Card -->
    <div class="col-md-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                @if($student->photo)

                    <img src="{{ asset('storage/'.$student->photo) }}"
                         width="180"
                         height="180"
                         class="rounded-circle border shadow mb-3">

                @else

                    <img src="{{ asset('images/default-user.png') }}"
                         width="180"
                         height="180"
                         class="rounded-circle border shadow mb-3">

                @endif

                <h4 class="fw-bold">
                    {{ $student->name }}
                </h4>

                <p class="text-muted mb-1">
                    {{ $student->student_id }}
                </p>

                <span class="badge bg-success">
                    {{ ucfirst($student->status) }}
                </span>

            </div>

        </div>

    </div>

    <!-- Student Information -->
    <div class="col-md-8">

        <div class="card shadow-sm">

            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-person-badge"></i>
                    Student Information
                </h5>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="30%">Student ID</th>
                        <td>{{ $student->student_id }}</td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td>{{ $student->name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $student->email }}</td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td>{{ $student->phone }}</td>
                    </tr>

                    <tr>
                        <th>Department</th>
                        <td>{{ $student->department->name ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Session</th>
                        <td>{{ $student->session }}</td>
                    </tr>

                    <tr>
                        <th>Semester</th>
                        <td>{{ $student->semester }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            @if($student->status == 'active')
                                <span class="badge bg-success">
                                    Active
                                </span>
                            @elseif($student->status == 'inactive')
                                <span class="badge bg-warning text-dark">
                                    Inactive
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Graduated
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Created Date</th>
                        <td>
                            {{ $student->created_at->format('d M Y') }}
                        </td>
                    </tr>

                </table>

                <div class="mt-3">

                    <a href="{{ route('students.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Back
                    </a>

                    <a href="{{ route('students.edit',$student->id) }}"
                       class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i>
                        Edit
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
```
