<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffAuthController;

// Protected Staff Routes
Route::middleware("auth:sanctum")->group(function () {

    Route::delete("/staff/{id}", [StaffController::class, "destroy"]);

    Route::get("/staff", [StaffController::class, "index"]);

    Route::get("/staff/{id}", [StaffController::class, "show"]);

    Route::put("/staff/{id}", [StaffController::class, "update"]);

    Route::post("/staff", [StaffController::class, "store"]);

    Route::get("/staff-me", [StaffAuthController::class, "me"]);

    Route::post("/staff-logout", [StaffAuthController::class, "logout"]);

});

// Customer Routes (Public)
Route::apiResource("customer", CustomerController::class)
    ->parameter("customer", "customer");

// Staff Login (Public)
Route::post("/staff/login", [StaffAuthController::class, "login"]);