<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;

// Protected Staff Routes
Route::middleware("auth:sanctum")->group(function () {

    Route::get('/staff-me', [StaffAuthController::class, 'me']);

    Route::post('/staff-logout', [StaffAuthController::class, 'logout']);

    Route::get("/staff/{id}", [StaffController::class, "show"]);

    Route::put("/staff/{id}", [StaffController::class, "update"]);

    Route::post("/staff", [StaffController::class, "store"]);

    Route::get("/staff-me", [StaffAuthController::class, "me"]);

    Route::post('/customer-logout', [CustomerAuthController::class, 'logout']);

});


// ANY AUTHENTICATED USER CAN READ

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/{category}', [CategoryController::class, 'show']);

    Route::get('/book', [BookController::class, 'index']);
    Route::get('/book/{book}', [BookController::class, 'show']);

});