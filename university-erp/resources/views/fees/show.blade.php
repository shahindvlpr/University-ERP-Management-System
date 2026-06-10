@extends('layouts.app')

@section('title','Fee Details')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-info text-white">

        <h5 class="mb-0">
            <i class="bi bi-receipt"></i>
            Fee Invoice Details
        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Invoice Number
                </label>

                <p>{{ $fee->invoice_no }}</p>

            </div>

            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Student Name
                </label>

                <p>{{ $fee->student->name }}</p>

            </div>

            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Student ID
                </label>

                <p>{{ $fee->student->student_id }}</p>

            </div>

            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Fee Type
                </label>

                <p>{{ $fee->fee_type }}</p>

            </div>

            <div class="col-md-4 mb-3">

                <label class="fw-bold">
                    Total Amount
                </label>

                <p class="text-primary fw-bold">
                    ৳{{ number_format($fee->amount,2) }}
                </p>

            </div>

            <div class="col-md-4 mb-3">

                <label class="fw-bold">
                    Paid Amount
                </label>

                <p class="text-success fw-bold">
                    ৳{{ number_format($fee->paid_amount,2) }}
                </p>

            </div>

            <div class="col-md-4 mb-3">

                <label class="fw-bold">
                    Due Amount
                </label>

                <p class="text-danger fw-bold">
                    ৳{{ number_format($fee->due_amount,2) }}
                </p>

            </div>

            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Due Date
                </label>

                <p>
                    {{ $fee->due_date->format('d M Y') }}
                </p>

            </div>

            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Status
                </label>

                <p>

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

                </p>

            </div>

            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Session
                </label>

                <p>{{ $fee->session }}</p>

            </div>

            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Semester
                </label>

                <p>{{ $fee->semester }}</p>

            </div>

            <div class="col-md-12 mb-3">

                <label class="fw-bold">
                    Remarks
                </label>

                <p>
                    {{ $fee->remarks ?? 'No Remarks' }}
                </p>

            </div>

        </div>

        <a href="{{ route('fees.edit',$fee->id) }}"
           class="btn btn-warning">

            <i class="bi bi-pencil-square"></i>
            Edit

        </a>

        <a href="{{ route('fees.index') }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Back

        </a>

    </div>

</div>

@endsection