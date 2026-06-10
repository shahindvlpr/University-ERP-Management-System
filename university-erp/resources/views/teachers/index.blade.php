@extends('layouts.app')

@section('title', 'Teachers')

@section('content')

<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <h5>
            Total Teachers:
            <span class="badge bg-primary">
                {{ $teachers->total() }}
            </span>
        </h5>
    </div>
</div>

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="bi bi-person-workspace"></i>
            Teachers
        </h5>

        <a href="{{ route('teachers.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Add Teacher
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

        <!-- Search -->
        <form method="GET" class="mb-4">

            <div class="input-group">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Search by Teacher Name or ID">

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
                    <th>Photo</th>
                    <th>Teacher ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Salary</th>
                    <th>Status</th>
                    <th width="180">Action</th>
                </tr>

            </thead>

            <tbody>

            @forelse($teachers as $teacher)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>

                        @if($teacher->photo)

                            <img src="{{ asset('storage/'.$teacher->photo) }}"
                                 width="55"
                                 height="55"
                                 class="rounded-circle border shadow-sm">

                        @else

                            <img src="{{ asset('images/default-user.png') }}"
                                 width="55"
                                 height="55"
                                 class="rounded-circle border shadow-sm">

                        @endif

                    </td>

                    <td>{{ $teacher->teacher_id }}</td>

                    <td>{{ $teacher->name }}</td>

                    <td>{{ $teacher->department->name ?? 'N/A' }}</td>

                    <td>{{ $teacher->designation }}</td>

                    <td>
                        ৳{{ number_format($teacher->salary, 2) }}
                    </td>

                    <td>

                        @if($teacher->status == 'active')

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Inactive
                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('teachers.show',$teacher->id) }}"
                           class="btn btn-info btn-sm"
                           title="View">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('teachers.edit',$teacher->id) }}"
                           class="btn btn-warning btn-sm"
                           title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('teachers.destroy',$teacher->id) }}"
                              method="POST"
                              style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this teacher?')">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="9" class="text-center">
                        No Teachers Found
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        </div>

        <div class="mt-3">
            {{ $teachers->appends(request()->query())->links() }}
        </div>

    </div>

</div>

@endsection

