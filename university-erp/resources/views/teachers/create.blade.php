@extends('layouts.app')

@section('title', 'Add Teacher')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-person-plus-fill"></i>
            Add New Teacher
        </h5>
    </div>

    <div class="card-body">

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST"
              enctype="multipart/form-data"
              action="{{ route('teachers.store') }}">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Teacher ID</label>
                    <input type="text"
                           name="teacher_id"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text"
                           name="name"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text"
                           name="phone"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Department</label>

                    <select name="department_id"
                            class="form-control">

                        @foreach($departments as $department)

                        <option value="{{ $department->id }}">
                            {{ $department->name }}
                        </option>

                        @endforeach

                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Designation</label>
                    <input type="text"
                           name="designation"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Specialization</label>
                    <input type="text"
                           name="specialization"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Joining Date</label>
                    <input type="date"
                           name="joining_date"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Salary</label>
                    <input type="number"
                           name="salary"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status</label>

                    <select name="status"
                            class="form-control">

                        <option value="active">
                            Active
                        </option>

                        <option value="inactive">
                            Inactive
                        </option>

                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Photo</label>
                    <input type="file"
                           name="photo"
                           class="form-control">
                </div>

            </div>

            <button class="btn btn-primary">
                <i class="bi bi-save"></i>
                Save Teacher
            </button>

        </form>

    </div>

</div>

@endsection

