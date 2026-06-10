@extends('layouts.app')

@section('title','Add Fee Invoice')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-primary text-white">

    <h5 class="mb-0">
        <i class="bi bi-cash-coin"></i>
        Create Fee Invoice
    </h5>

</div>

<div class="card-body">

    <form method="POST"
          action="{{ route('fees.store') }}">

        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Student
                </label>

                <select name="student_id"
                        class="form-select"
                        required>

                    <option value="">
                        Select Student
                    </option>

                    @foreach($students as $student)

                    <option value="{{ $student->id }}">

                        {{ $student->name }}
                        ({{ $student->student_id }})

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Invoice Number
                </label>

                <input type="text"
                       name="invoice_no"
                       class="form-control"
                       value="INV-{{ time() }}"
                       readonly>

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">
                    Total Amount
                </label>

                <input type="number"
                       name="amount"
                       class="form-control"
                       required>

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">
                    Paid Amount
                </label>

                <input type="number"
                       name="paid_amount"
                       class="form-control"
                       value="0">

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">
                    Due Amount
                </label>

                <input type="number"
                       name="due_amount"
                       class="form-control"
                       value="0">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Due Date
                </label>

                <input type="date"
                       name="due_date"
                       class="form-control"
                       required>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Fee Type
                </label>

                <select name="fee_type"
                        class="form-select"
                        required>

                    <option value="Tuition Fee">
                        Tuition Fee
                    </option>

                    <option value="Exam Fee">
                        Exam Fee
                    </option>

                    <option value="Library Fee">
                        Library Fee
                    </option>

                    <option value="Lab Fee">
                        Lab Fee
                    </option>

                </select>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Session
                </label>

                <input type="number"
                       name="session"
                       class="form-control"
                       value="{{ date('Y') }}"
                       required>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Semester
                </label>

                <input type="number"
                       name="semester"
                       class="form-control"
                       required>

            </div>

            <div class="col-md-12 mb-3">

                <label class="form-label">
                    Remarks
                </label>

                <textarea name="remarks"
                          rows="3"
                          class="form-control"></textarea>

            </div>

        </div>

        <button class="btn btn-success">

            <i class="bi bi-check-circle"></i>
            Save Invoice

        </button>

        <a href="{{ route('fees.index') }}"
           class="btn btn-secondary">

            Back

        </a>

    </form>

</div>

</div>

@endsection
