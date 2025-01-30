<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use App\Models\Year;
use App\Models\Semester;
use Illuminate\Support\Str; 
use Illuminate\Http\Request;

class MarksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        // Fetch all marks with related student, year, and semester
        $marks = Mark::with(['student', 'year', 'semester'])->get();

        return response()->json($marks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'subject' => 'required|string|max:255',
            'total_marks' => 'required|integer',
            'midterm_marks' => 'required|integer',
            'assignment_marks' => 'required|integer',
            'student_id' => 'required|exists:students,id',
            'year_id' => 'required|exists:years,id',
            'sem_id' => 'required|exists:semesters,id',
        ]);

        // Create the mark entry
        $mark = Mark::create([
            'id'=> Str::uuid(),
            'subject' => $request->subject,
            'total_marks' => $request->total_marks,
            'midterm_marks' => $request->midterm_marks,
            'assignment_marks' => $request->assignment_marks,
            'student_id' => $request->student_id,
            'year_id' => $request->year_id,
            'sem_id' => $request->sem_id,
        ]);

        return response()->json(['message' => 'Marks create successfully', 'student' => $mark], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find a mark by ID and load related data
        $mark = Mark::with(['student', 'year', 'semester'])->findOrFail($id);

        if (!$mark) {
            return response()->json(['message' => 'Mark not found'], 404);
        }

        return response()->json($mark);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the mark to update
        $mark = Mark::find($id);

        if (!$mark) {
            return response()->json(['message' => 'Mark not found'], 404);
        }

        // Validate request data
        $request->validate([
            'subject' => 'string|max:255',
            'total_marks' => 'integer',
            'midterm_marks' => 'integer',
            'assignment_marks' => 'integer',
            'student_id' => 'exists:students,id',
            'year_id' => 'exists:years,id',
            'sem_id' => 'exists:semesters,id',
        ]);

        // Update the mark entry
        $mark->update($request->all());

        return response()->json($mark);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the mark to delete
        $mark = Mark::find($id);

        if (!$mark) {
            return response()->json(['message' => 'Mark not found'], 404);
        }

        // Delete the mark entry
        $mark->delete();

        return response()->json(['message' => 'Mark deleted successfully']);
    }
}
