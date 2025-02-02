<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; // Assuming you have a `Student` model
use Illuminate\Support\Str; 
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all students
        $students = Student::all();
        return response()->json([
            'success' => true,
            'message' => 'Students retrieved successfully.',
            'students' => $students
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $student = Student::create([
            'id'=> Str::uuid(),
            'name' => $request->name,
            'roll_no' => $request->roll_no,
            'phone' => $request->phone,
            'branch' => $request->branch,
            'session' => $request->session,
        ]);
        
        // Create a new student
        $student = Student::create($request->all());

        return response()->json(['message' => 'Student created successfully', 'student' => $student], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the student by ID
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json(['student' => $student], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the student by ID
        $student = Student::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'roll_no' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'branch' => 'required|string|max:100',
            'session' => 'required|string|max:50',
        ]);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Update the student
        $student->update($validatedData);

        return response()->json(['message' => 'Student updated successfully', 'student' => $student], 200);
    }

    public function destroy(string $id)
    {
        // Find the student by ID
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Delete the student
        $student->delete();

        return response()->json(['message' => 'Student deleted successfully'], 200);
    }
}
