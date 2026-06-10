@extends('layouts.app')

@section('title','Attendance')

@section('content')

<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <h5>
            Total Attendance Records:
            <span class="badge bg-primary">
                {{ $attendances->total() }}
            </span>
        </h5>
    </div>
</div>

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="bi bi-calendar-check"></i>
            Attendance Records
        </h5>

        <a href="{{ route('attendance.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Add Attendance

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
        @endif

        <!-- Search Box -->
        <form method="GET" class="mb-4">

            <div class="input-group">

                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search by Student Name or Student ID"
                       value="{{ request('search') }}">

                <button class="btn btn-primary">
                    <i class="bi bi-search"></i>
                    Search
                </button>

            </div>

        </form>

        <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-dark">

                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th width="220">Action</th>
                </tr>

            </thead>

            <tbody>

            @forelse($attendances as $attendance)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $attendance->student->name }}
                    </td>

                    <td>
                        {{ $attendance->course->name }}
                    </td>

                    <td>
                        {{ $attendance->date->format('d M Y') }}
                    </td>

                    <td>

                        @if($attendance->status == 'present')

                            <span class="badge bg-success">
                                Present
                            </span>

                        @elseif($attendance->status == 'late')

                            <span class="badge bg-warning text-dark">
                                Late
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Absent
                            </span>

                        @endif

                    </td>

                    <td class="text-nowrap">

                        <a href="{{ route('attendance.show',$attendance->id) }}"
                           class="btn btn-info btn-sm">

                            <i class="bi bi-eye"></i>

                        </a>

                        <a href="{{ route('attendance.edit',$attendance->id) }}"
                           class="btn btn-warning btn-sm">

                            <i class="bi bi-pencil"></i>

                        </a>

                        <form action="{{ route('attendance.destroy',$attendance->id) }}"
                              method="POST"
                              style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete Attendance Record?')">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6"
                        class="text-center">

                        No Attendance Records Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        </div>

        <div class="mt-3">
            {{ $attendances->appends(request()->query())->links() }}
        </div>

    </div>

</div>

@endsection
