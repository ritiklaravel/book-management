@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-primary">Books</h1>
                <form class="d-flex" method="GET" action="{{ route('books.index') }}">
                    <input type="text" class="form-control me-2" name="search" placeholder="Search books" value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>

            @foreach ($books as $book)
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-dark">{{ $book->title }}</h3>
                        <p class="text-muted">Author: {{ $book->author }}</p>
                        <p class="card-text">{{ $book->description }}</p>

                        @auth
                        <div class="mt-3">
                            {{-- Display Star Rating if it exists --}}
                            @if ($book->rating)
                                <p class="mb-1">Your Rating:</p>
                                <div>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa{{ $i <= $book->rating ? 's' : 'r' }} fa-star text-warning"></i>
                                    @endfor
                                </div>
                            @else
                                {{-- Rating Dropdown --}}
                                <form class="d-inline me-3" method="POST" action="/books/{{ $book->id }}/rate">
                                    @csrf
                                    <label for="rating-{{ $book->id }}" class="form-label">Rate:</label>
                                    <select class="form-select d-inline w-auto" id="rating-{{ $book->id }}" name="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <button class="btn btn-sm btn-success mt-2" type="submit">Submit</button>
                                </form>
                            @endif

                            {{-- Display Comment if it exists --}}
                            @if ($book->comment)
                                <p class="mt-3"><strong>Your Comment:</strong> {{ $book->comment }}</p>
                            @else
                                {{-- Comment Form --}}
                                <form method="POST" action="/books/{{ $book->id }}/comment">
                                    @csrf
                                    <textarea class="form-control mb-2" name="comment" placeholder="Leave a comment" rows="2"></textarea>
                                    <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                                </form>
                            @endif
                        </div>
                        @endauth
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
