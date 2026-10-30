<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/staff", [StaffController::class, "index"]);
Route::post("/staff", [StaffController::class, "store"]);
Route::get("/staff/{id}", [StaffController::class, "show"]);
Route::put("/staff/{id}", [StaffController::class, "update"]);
Route::delete("/staff/{id}", [StaffController::class, "destroy"]);