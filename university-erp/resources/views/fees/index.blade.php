@extends('layouts.app')

@section('title','Fees Management')

@section('content')

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center">

    <h5 class="mb-0">
        <i class="bi bi-cash-coin"></i>
        Fee Invoices
    </h5>

    <a href="{{ route('fees.create') }}"
       class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>
        Add Invoice

    </a>

</div>

<div class="card-body">

    <form method="GET" class="mb-3">

        <div class="input-group">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search Student">

            <button class="btn btn-primary">
                Search
            </button>

        </div>

    </form>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-dark">

            <tr>

                <th>Invoice No</th>
                <th>Student</th>
                <th>Fee Type</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Status</th>
                <th>Action</th>

            </tr>

            </thead>

            <tbody>

            @forelse($fees as $fee)

            <tr>

                <td>{{ $fee->invoice_no }}</td>

                <td>
                    {{ $fee->student->name }}
                </td>

                <td>
                    {{ ucfirst($fee->fee_type) }}
                </td>

                <td>
                    ৳{{ number_format($fee->amount,2) }}
                </td>

                <td>
                    ৳{{ number_format($fee->paid_amount,2) }}
                </td>

                <td>
                    ৳{{ number_format($fee->due_amount,2) }}
                </td>

                <td>

                    @if($fee->status=='paid')

                    <span class="badge bg-success">
                        Paid
                    </span>

                    @elseif($fee->status=='partial')

                    <span class="badge bg-warning">
                        Partial
                    </span>

                    @else

                    <span class="badge bg-danger">
                        Unpaid
                    </span>

                    @endif

                </td>

                <td>

                    <a href="{{ route('fees.show',$fee->id) }}"
                       class="btn btn-info btn-sm">

                        <i class="bi bi-eye"></i>

                    </a>

                    <a href="{{ route('fees.edit',$fee->id) }}"
                       class="btn btn-warning btn-sm">

                        <i class="bi bi-pencil"></i>

                    </a>

                    <form action="{{ route('fees.destroy',$fee->id) }}"
                          method="POST"
                          style="display:inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete Invoice?')">

                            <i class="bi bi-trash"></i>

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8" class="text-center">

                    No Fee Records Found

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{ $fees->links() }}

</div>


</div>

@endsection
