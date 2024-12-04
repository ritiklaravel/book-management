<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Comment;

class BookController extends Controller
{
    public function index(Request $request)
{
    $books = Book::with(['userRating', 'userComment'])
        ->when($request->search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%")->orWhere('author', 'like', "%{$search}%");
        })
        ->paginate(10);

    return view('books.index', compact('books'));
}

public function rate(Request $request, Book $book)
{
    $request->validate(['rating' => 'required|integer|min:1|max:5']);

    Rating::updateOrCreate(
        ['user_id' => auth()->id(), 'book_id' => $book->id],
        ['rating' => $request->rating]
    );

    return redirect()->back()->with('success', 'Rating submitted successfully.');
}

public function comment(Request $request, Book $book)
{
    $request->validate(['comment' => 'required|string']);

    Comment::updateOrCreate(
        ['user_id' => auth()->id(), 'book_id' => $book->id],
        ['comment' => $request->comment]
    );

    return redirect()->back()->with('success', 'Comment submitted successfully.');
}
}
