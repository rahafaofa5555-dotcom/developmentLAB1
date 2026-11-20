<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Customer;
use Illuminate\Http\Request;

class BorrowingsController extends Controller
{
    // GET /borrow (customer): my borrowings, each book with a pivot object
    public function index()
    {
        $user = auth()->user();

        return response()->json(["data" => $user->books]);
    }

    // POST /borrow (customer)
    public function borrow(Request $request)
    {
        // Task 3: no dates in the past, return date after borrowing date
        $data = $request->validate([
            "book_id"        => ["required", "exists:books,id"],
            "borrowing_date" => ["required", "date", "after_or_equal:today"],
            "return_date"    => ["required", "date", "after:borrowing_date"],
        ]);

        // Task 5: maximum 3 open borrowings per customer
        $openCount = auth()->user()->books()
            ->wherePivot("is_returned", false)
            ->count();

        if ($openCount >= 3) {
            return response()->json([
                "message" => "You already have 3 books that are not returned",
            ], 422);
        }

        // Task 4: no two customers on the same book at the same time
        // Two ranges overlap when old start <= new end AND old end >= new start
        $isTaken = Book::find($data["book_id"])->customers()
            ->wherePivot("is_returned", false)
            ->wherePivot("borrowing_date", "<=", $data["return_date"])
            ->wherePivot("return_date", ">=", $data["borrowing_date"])
            ->exists();

        if ($isTaken) {
            return response()->json([
                "message" => "This book is already borrowed on these dates",
            ], 422);
        }

        // attach(book id, extra pivot columns)
        auth()->user()->books()->attach(
            $data["book_id"],
            [
                "borrowing_date" => $data["borrowing_date"],
                "return_date"    => $data["return_date"],
                "is_returned"    => false,
            ]
        );

        // Small fix: attach() returns nothing, so return a message with 201
        return response()->json(["message" => "Book borrowed successfully"], 201);
    }

    // DELETE /borrow/{id} (customer, id = book id)
    // Small fix: only cancel a borrowing that has not started yet, so history is kept
    public function destroy($id)
    {
        $user = auth()->user();

        $borrowing = $user->books()
            ->wherePivot("book_id", $id)
            ->wherePivot("is_returned", false)
            ->wherePivot("borrowing_date", ">", now()->toDateString())
            ->first();

        if (!$borrowing) {
            return response()->json([
                "message" => "You can only cancel a borrowing before its borrowing date",
            ], 422);
        }

        $user->books()
            ->wherePivot("is_returned", false)
            ->wherePivot("borrowing_date", ">", now()->toDateString())
            ->detach($id);

        return response()->json(["message" => "done"]);
    }

    // PUT /borrow (staff): Part 8, mark a book as returned
    public function markAsReturned(Request $request)
    {
        $request->validate([
            "customer_id" => ["required", "exists:customers,id"],
            "book_id"     => ["required", "exists:books,id"],
        ]);

        $customer = Customer::find($request->customer_id);

        $borrowing = $customer->books()
            ->wherePivot("book_id", $request->book_id)
            ->wherePivot("is_returned", false)
            ->first();

        if (!$borrowing) {
            return response()->json([
                "message" => "This customer has no open borrowing for this book",
            ], 404);
        }

        $customer->books()
            ->wherePivot("is_returned", false)
            ->updateExistingPivot($request->book_id, [
                "is_returned" => true,
            ]);

        return response()->json([
            "message"        => "Book marked as returned",
            "customer_id"    => $customer->id,
            "book_id"        => $borrowing->id,
            "borrowing_date" => $borrowing->pivot->borrowing_date,
        ]);
    }

    // GET /borrow/all (staff): Task 6, every borrowing with customer and book
    // Extra: ?is_returned=0 shows only open ones
    public function all(Request $request)
    {
        $query = Borrowing::with(["customer", "book"]);

        if ($request->has("is_returned")) {
            $query->where("is_returned", $request->boolean("is_returned"));
        }

        return response()->json($query->get());
    }

    // GET /borrow/overdue (staff): Task 7, open borrowings whose return date has passed
    public function overdue()
    {
        $late = Borrowing::with(["customer", "book"])
            ->where("is_returned", false)
            ->where("return_date", "<", now()->toDateString())
            ->get();

        return response()->json($late);
    }
}
