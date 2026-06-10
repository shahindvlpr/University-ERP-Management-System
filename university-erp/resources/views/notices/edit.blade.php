@extends('layouts.app')

@section('title','Edit Notice')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-warning">

    Edit Notice

</div>

<div class="card-body">

<form method="POST"
      action="{{ route('notices.update',$notice->id) }}">

    @csrf
    @method('PUT')

    <div class="mb-3">

        <label>Title</label>

        <input type="text"
               name="title"
               value="{{ $notice->title }}"
               class="form-control">

    </div>

    <div class="mb-3">

        <label>Content</label>

        <textarea name="content"
                  rows="5"
                  class="form-control">{{ $notice->content }}</textarea>

    </div>

    <div class="row">

        <div class="col-md-4">

            <label>Category</label>

            <select name="category"
                    class="form-select">

                <option value="general"
                {{ $notice->category=='general'?'selected':'' }}>
                General
                </option>

                <option value="exam"
                {{ $notice->category=='exam'?'selected':'' }}>
                Exam
                </option>

                <option value="event"
                {{ $notice->category=='event'?'selected':'' }}>
                Event
                </option>

                <option value="holiday"
                {{ $notice->category=='holiday'?'selected':'' }}>
                Holiday
                </option>

            </select>

        </div>

        <div class="col-md-4">

            <label>Audience</label>

            <select name="audience"
                    class="form-select">

                <option value="all"
                {{ $notice->audience=='all'?'selected':'' }}>
                All
                </option>

                <option value="students"
                {{ $notice->audience=='students'?'selected':'' }}>
                Students
                </option>

                <option value="teachers"
                {{ $notice->audience=='teachers'?'selected':'' }}>
                Teachers
                </option>

            </select>

        </div>

        <div class="col-md-4">

            <label>Publish Date</label>

            <input type="date"
                   name="publish_date"
                   value="{{ $notice->publish_date->format('Y-m-d') }}"
                   class="form-control">

        </div>

    </div>

    <div class="mt-3">

        <label>Expire Date</label>

        <input type="date"
               name="expire_date"
               value="{{ $notice->expire_date ? $notice->expire_date->format('Y-m-d') : '' }}"
               class="form-control">

    </div>

    <button class="btn btn-success mt-3">

        Update Notice

    </button>

</form>

</div>

</div>

@endsection