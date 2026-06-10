@extends('layouts.app')

@section('title','Edit Fee Invoice')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-warning">

        <h5 class="mb-0">
            <i class="bi bi-pencil-square"></i>
            Edit Fee Invoice
        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('fees.update',$fee->id) }}">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Student
                    </label>

                    <select name="student_id"
                            class="form-select"
                            required>

                        @foreach($students as $student)

                        <option value="{{ $student->id }}"
                            {{ $fee->student_id == $student->id ? 'selected' : '' }}>

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
                           class="form-control"
                           value="{{ $fee->invoice_no }}"
                           readonly>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Total Amount
                    </label>

                    <input type="number"
                           name="amount"
                           value="{{ $fee->amount }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Paid Amount
                    </label>

                    <input type="number"
                           name="paid_amount"
                           value="{{ $fee->paid_amount }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Due Amount
                    </label>

                    <input type="number"
                           value="{{ $fee->due_amount }}"
                           class="form-control"
                           readonly>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Due Date
                    </label>

                    <input type="date"
                           name="due_date"
                           value="{{ $fee->due_date->format('Y-m-d') }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Fee Type
                    </label>

                    <select name="fee_type"
                            class="form-select">

                        <option value="Tuition Fee"
                            {{ $fee->fee_type == 'Tuition Fee' ? 'selected' : '' }}>
                            Tuition Fee
                        </option>

                        <option value="Exam Fee"
                            {{ $fee->fee_type == 'Exam Fee' ? 'selected' : '' }}>
                            Exam Fee
                        </option>

                        <option value="Library Fee"
                            {{ $fee->fee_type == 'Library Fee' ? 'selected' : '' }}>
                            Library Fee
                        </option>

                        <option value="Lab Fee"
                            {{ $fee->fee_type == 'Lab Fee' ? 'selected' : '' }}>
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
                           value="{{ $fee->session }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Semester
                    </label>

                    <input type="number"
                           name="semester"
                           value="{{ $fee->semester }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-12 mb-3">

                    <label class="form-label">
                        Remarks
                    </label>

                    <textarea name="remarks"
                              rows="3"
                              class="form-control">{{ $fee->remarks }}</textarea>

                </div>

            </div>

            <button class="btn btn-success">

                <i class="bi bi-check-circle"></i>
                Update Invoice

            </button>

            <a href="{{ route('fees.index') }}"
               class="btn btn-secondary">

                Back

            </a>

        </form>

    </div>

</div>

@endsection