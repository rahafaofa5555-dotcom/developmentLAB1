<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingsController;

// Staff only
Route::middleware("auth:staff")->group(function () {
    Route::delete("/staff/{id}", [StaffController::class, "destroy"]);
    Route::get("/staff", [StaffController::class, "index"]);
    Route::get("/staff/{id}", [StaffController::class, "show"]);
    Route::put("/staff/{id}", [StaffController::class, "update"]);
    Route::post("/staff", [StaffController::class, "store"]);
    Route::get("/staff-me", [StaffAuthController::class, "me"]);
    Route::post("/staff-logout", [StaffAuthController::class, "logout"]);

    // Task 2: staff manage customers (moved here from the customer group)
    Route::apiResource("customer", CustomerController::class)
        ->parameter("customer", "customer");

    Route::post("/category", [CategoryController::class, "store"]);
    Route::put("/category/{category}", [CategoryController::class, "update"]);
    Route::delete("/category/{category}", [CategoryController::class, "destroy"]);
    Route::post("/book", [BookController::class, "store"]);
    Route::put("/book/{book}", [BookController::class, "update"]);
    Route::delete("/book/{book}", [BookController::class, "destroy"]);

    // Part 8 + Tasks 6 and 7
    Route::put("/borrow", [BorrowingsController::class, "markAsReturned"]);
    Route::get("/borrow/all", [BorrowingsController::class, "all"]);
    Route::get("/borrow/overdue", [BorrowingsController::class, "overdue"]);
});

// Customers only
Route::middleware("auth:customers")->group(function () {
    Route::get("/customer-me", [CustomerAuthController::class, "me"]);
    Route::post("/customer-logout", [CustomerAuthController::class, "logout"]);

    // Part 7: borrowings
    Route::post("/borrow", [BorrowingsController::class, "borrow"]);
    Route::get("/borrow", [BorrowingsController::class, "index"]);
    Route::delete("/borrow/{id}", [BorrowingsController::class, "destroy"]);
});

// Any logged-in user can read
Route::middleware("auth:sanctum")->group(function () {
    Route::get("/category", [CategoryController::class, "index"]);
    Route::get("/category/{category}", [CategoryController::class, "show"]);
    Route::get("/book", [BookController::class, "index"]);
    Route::get("/book/{book}", [BookController::class, "show"]);
});

// Public
Route::post("/staff/login", [StaffAuthController::class, "login"]);
Route::post("/customer/login", [CustomerAuthController::class, "login"]);
Route::post("/customer/register", [CustomerAuthController::class, "register"]); // Task 1
