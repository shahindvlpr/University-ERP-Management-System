@extends('layouts.app')

@section('title','Add Book')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">

        Add New Book

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('books.store') }}">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Book Name</label>

                    <input type="text"
                           name="book_name"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Book Code</label>

                    <input type="text"
                           name="book_code"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Author</label>

                    <input type="text"
                           name="author"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Publisher</label>

                    <input type="text"
                           name="publisher"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Quantity</label>

                    <input type="number"
                           name="quantity"
                           class="form-control"
                           required>

                </div>

            </div>

            <button class="btn btn-success">

                Save Book

            </button>

        </form>

    </div>

</div>

@endsection