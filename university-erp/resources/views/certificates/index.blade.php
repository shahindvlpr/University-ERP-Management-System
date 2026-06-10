@extends('layouts.app')

@section('title','Certificates')

@section('content')

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between">

    <h5 class="mb-0">

        <i class="bi bi-patch-check-fill"></i>

        Certificates

    </h5>

    <a href="{{ route('certificates.create') }}"
       class="btn btn-primary">

        Generate Certificate

    </a>

</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead>

<tr>

    <th>Certificate No</th>
    <th>Student</th>
    <th>Type</th>
    <th>Issue Date</th>
    <th width="150">Action</th>

</tr>

</thead>

<tbody>

@forelse($certificates as $certificate)

<tr>

    <td>{{ $certificate->certificate_no }}</td>

    <td>{{ $certificate->student->name }}</td>

    <td>{{ $certificate->certificate_type }}</td>

    <td>{{ $certificate->issue_date }}</td>

    <td>

        <a href="{{ route('certificates.show',$certificate->id) }}"
           class="btn btn-info btn-sm">

            View

        </a>

        <form method="POST"
              action="{{ route('certificates.destroy',$certificate->id) }}"
              class="d-inline">

            @csrf
            @method('DELETE')

            <button class="btn btn-danger btn-sm">

                Delete

            </button>

        </form>

    </td>

</tr>

@empty

<tr>

<td colspan="5"
    class="text-center">

    No Certificate Found

</td>

</tr>

@endforelse

</tbody>

</table>

{{ $certificates->links() }}

</div>

</div>

@endsection