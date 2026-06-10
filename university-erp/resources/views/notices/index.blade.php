@extends('layouts.app')

@section('title','Notices')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="bi bi-megaphone-fill"></i>
            Notice Management
        </h5>

        <a href="{{ route('notices.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Add Notice

        </a>

    </div>

    <div class="card-body">

        <form method="GET" class="mb-3">

            <div class="input-group">

                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search Notice"
                       value="{{ request('search') }}">

                <button class="btn btn-primary">
                    Search
                </button>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                <tr>

                    <th>Title</th>
                    <th>Category</th>
                    <th>Audience</th>
                    <th>Publish Date</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>

                </thead>

                <tbody>

                @forelse($notices as $notice)

                <tr>

                    <td>{{ $notice->title }}</td>

                    <td>

                        <span class="badge bg-info">
                            {{ ucfirst($notice->category) }}
                        </span>

                    </td>

                    <td>{{ ucfirst($notice->audience) }}</td>

                    <td>
                        {{ $notice->publish_date->format('d M Y') }}
                    </td>

                    <td>

                        @if($notice->is_published)

                        <span class="badge bg-success">
                            Published
                        </span>

                        @else

                        <span class="badge bg-danger">
                            Draft
                        </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('notices.show',$notice->id) }}"
                           class="btn btn-info btn-sm">

                            <i class="bi bi-eye"></i>

                        </a>

                        <a href="{{ route('notices.edit',$notice->id) }}"
                           class="btn btn-warning btn-sm">

                            <i class="bi bi-pencil"></i>

                        </a>

                        <form action="{{ route('notices.destroy',$notice->id) }}"
                              method="POST"
                              style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete Notice?')">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">

                        No Notice Found

                    </td>

                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        {{ $notices->links() }}

    </div>

</div>

@endsection