@extends('layouts.app')

@section('title','Edit Book')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-warning">

        Edit Book

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('books.update',$book->id) }}">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Book Name</label>

                    <input type="text"
                           name="book_name"
                           value="{{ $book->book_name }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Author</label>

                    <input type="text"
                           name="author"
                           value="{{ $book->author }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Publisher</label>

                    <input type="text"
                           name="publisher"
                           value="{{ $book->publisher }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Quantity</label>

                    <input type="number"
                           name="quantity"
                           value="{{ $book->quantity }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Status</label>

                    <select name="status"
                            class="form-select">

                        <option value="available">
                            Available
                        </option>

                        <option value="unavailable">
                            Unavailable
                        </option>

                    </select>

                </div>

            </div>

            <button class="btn btn-success">

                Update Book

            </button>

        </form>

    </div>

</div>

@endsection