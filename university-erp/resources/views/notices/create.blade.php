@extends('layouts.app')

@section('title','Add Notice')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">

        <h5 class="mb-0">
            Create Notice
        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('notices.store') }}">

            @csrf

            <div class="mb-3">

                <label>Title</label>

                <input type="text"
                       name="title"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label>Content</label>

                <textarea name="content"
                          rows="5"
                          class="form-control"
                          required></textarea>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label>Category</label>

                    <select name="category"
                            class="form-select">

                        <option value="general">General</option>
                        <option value="exam">Exam</option>
                        <option value="event">Event</option>
                        <option value="holiday">Holiday</option>

                    </select>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Audience</label>

                    <select name="audience"
                            class="form-select">

                        <option value="all">All</option>
                        <option value="students">Students</option>
                        <option value="teachers">Teachers</option>

                    </select>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Publish Date</label>

                    <input type="date"
                           name="publish_date"
                           class="form-control"
                           required>

                </div>

            </div>

            <div class="mb-3">

                <label>Expire Date</label>

                <input type="date"
                       name="expire_date"
                       class="form-control">

            </div>

            <div class="form-check mb-3">

                <input type="checkbox"
                       class="form-check-input"
                       name="is_published"
                       checked>

                <label class="form-check-label">

                    Publish Immediately

                </label>

            </div>

            <button class="btn btn-success">

                Save Notice

            </button>

        </form>

    </div>

</div>

@endsection