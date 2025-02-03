<?php

namespace App\Http\Controllers;

use App\Http\Requests\Marks\MarksRequest;
use App\Http\Resources\Marks\MarksResource;
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
    public function index(Request $request)
    {
        $query = Mark::with(['student', 'year', 'semester']);

        // Check if a search query is provided
        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('roll_no', 'LIKE', '%' . $request->search . '%');;
                
            });
        }
    
        $marks = $query->get();
        if ($marks->isEmpty()) {
            return response()->json([
                'message' => 'No matching student found.',
                'status' => false
            ], 200);
        }
        return MarksResource::collection($marks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarksRequest $request)
    {

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

        return new MarksResource($mark);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MarksRequest $request, string $id)
    {
        // Find the mark to update
        $mark = Mark::find($id);

        if (!$mark) {
            return response()->json(['message' => 'Mark not found'], 404);
        }

        // Update the mark entry
        $mark->update($request->all());

        return response()->json(['success'=>true,'message' => 'Marks create successfully', 'data' => $mark], 200);
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
