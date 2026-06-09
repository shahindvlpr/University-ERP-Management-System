@extends('layouts.app')

@section('content')

<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <h5>
            Total Students:
            <span class="badge bg-primary">
                {{ $students->total() }}
            </span>
        </h5>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('students.create') }}"
       class="btn btn-primary">
        Add Student
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
    </button>
</div>
@endif

<form method="GET" class="mb-4">
    <div class="input-group">
        <input type="text"
               name="search"
               class="form-control"
               placeholder="Search by Name or Student ID"
               value="{{ request('search') }}">

        <button class="btn btn-primary">
            Search
        </button>
    </div>
</form>

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">

    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Student ID</th>
            <th>Department</th>
            <th>Status</th>
            <th>Created</th>
            <th width="220">Action</th>
        </tr>
    </thead>

    <tbody>

    @forelse($students as $student)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>
                @if($student->photo)
                    <img src="{{ asset('storage/'.$student->photo) }}"
                         width="60"
                         height="60"
                         class="rounded-circle border shadow-sm">
                @else
                    <img src="{{ asset('images/default-user.png') }}"
                         width="60"
                         height="60"
                         class="rounded-circle border shadow-sm">
                @endif
            </td>

            <td>{{ $student->name }}</td>

            <td>{{ $student->student_id }}</td>

            <td>{{ $student->department->name ?? 'N/A' }}</td>

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

            <td>
                {{ $student->created_at->format('d M Y') }}
            </td>

            <td>

                <a href="{{ route('students.show',$student->id) }}"
                   class="btn btn-info btn-sm">
                    👁 View
                </a>

                <a href="{{ route('students.edit',$student->id) }}"
                   class="btn btn-warning btn-sm">
                    ✏ Edit
                </a>

                <form method="POST"
                      action="{{ route('students.destroy',$student->id) }}"
                      style="display:inline;">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure to delete this student?')">
                        🗑 Delete
                    </button>

                </form>

            </td>

        </tr>

    @empty

        <tr>
            <td colspan="8" class="text-center">
                No Students Found
            </td>
        </tr>

    @endforelse

    </tbody>

</table>
</div>

<div class="mt-3">
    {{ $students->appends(request()->query())->links() }}
</div>

@endsection