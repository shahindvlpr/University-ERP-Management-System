@extends('layouts.app')

@section('title','Edit Result')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-warning">

        Edit Result

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('results.update',$result->id) }}">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label>Midterm Marks</label>

                    <input type="number"
                           name="midterm_marks"
                           value="{{ $result->midterm_marks }}"
                           class="form-control">

                </div>

                <div class="col-md-4 mb-3">

                    <label>Final Marks</label>

                    <input type="number"
                           name="final_marks"
                           value="{{ $result->final_marks }}"
                           class="form-control">

                </div>

                <div class="col-md-4 mb-3">

                    <label>Assignment Marks</label>

                    <input type="number"
                           name="assignment_marks"
                           value="{{ $result->assignment_marks }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Session</label>

                    <input type="number"
                           name="session"
                           value="{{ $result->session }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Semester</label>

                    <input type="number"
                           name="semester"
                           value="{{ $result->semester }}"
                           class="form-control">

                </div>

            </div>

            <button class="btn btn-success">
                Update Result
            </button>

        </form>

    </div>

</div>

@endsection
