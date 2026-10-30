<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Staff::all());
    }
    public function show($id)
    {
    return response()->json(Staff::findOrFail($id));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        "name"         => "required|string",
        "email"        => "required|email|unique:staff,email",
        "password"     => "required|string|min:8",
        "role"         => "required|string",
        "phone_number" => "required|string|unique:staff,phone_number"
    ]);

    $staff = Staff::create($request->all());
    return response()->json($staff);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $staff = Staff::findOrFail($id);
    
    $request->validate([
        "name"         => "sometimes|required|string",
        "email"        => "sometimes|required|email|unique:staff,email," . $staff->id,
        "password"     => "sometimes|required|string|min:8",
        "role"         => "sometimes|required|string",
        "phone_number" => "sometimes|required|string|unique:staff,phone_number," . $staff->id
    ]);

    $staff->update($request->all());
    return response()->json($staff);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    Staff::findOrFail($id)->delete();
    return response()->json("Staff member deleted successfully.");
} 
}
