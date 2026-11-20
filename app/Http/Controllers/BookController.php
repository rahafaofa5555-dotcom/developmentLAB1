<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Task 8: optional ?search= (part of the name) and ?category_id=
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->search) {
            $query->where("name", "like", "%" . $request->search . "%");
        }
        if ($request->category_id) {
            $query->where("category_id", $request->category_id);
        }

        return BookResource::collection($query->get());
    }

    public function store(BookStoreRequest $request)
    {
        $book = Book::create($request->validated());

        return BookResource::make($book);
    }

    public function show(Book $book)
    {
        return new BookResource($book->load("category"));
    }

    public function update(BookUpdateRequest $request, Book $book)
    {
        $book->update($request->validated());

        return BookResource::make($book);
    }

    public function destroy(Book $book)
    {
        // Small fix: a borrowed book can't be deleted (foreign key), so answer 409 instead of 500
        if ($book->customers()->exists()) {
            return response()->json([
                'message' => 'This book has borrowings and cannot be deleted'
            ], 409);
        }

        $book->delete();

        return response()->json([
            'message' => 'deleted'
        ]);
    }
}
