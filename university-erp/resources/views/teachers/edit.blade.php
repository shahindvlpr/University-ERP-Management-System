@extends('layouts.app')

@section('title', 'Edit Teacher')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-warning">
        <h5 class="mb-0">
            Edit Teacher
        </h5>
    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('teachers.update',$teacher->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text"
                           name="name"
                           value="{{ $teacher->name }}"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           value="{{ $teacher->email }}"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text"
                           name="phone"
                           value="{{ $teacher->phone }}"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Designation</label>
                    <input type="text"
                           name="designation"
                           value="{{ $teacher->designation }}"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Salary</label>
                    <input type="number"
                           name="salary"
                           value="{{ $teacher->salary }}"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status</label>

                    <select name="status"
                            class="form-control">

                        <option value="active"
                        {{ $teacher->status=='active'?'selected':'' }}>
                            Active
                        </option>

                        <option value="inactive"
                        {{ $teacher->status=='inactive'?'selected':'' }}>
                            Inactive
                        </option>

                    </select>

                </div>

            </div>

            <button class="btn btn-success">
                Update Teacher
            </button>

        </form>

    </div>

</div>

@endsection