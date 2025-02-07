<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course= Course::all();
        return response()->json([
            'success' => true,
            'message' => 'Course Category retrieved successfully.',
            'data' => $course
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'required|string|max:255',
            'duration'    => 'required|integer',
            'instructor'  => 'required|string|max:255',
            'credits'     => 'required|integer',
            'fee'         => 'nullable|numeric',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date',
        ]);

        // Generate a UUID for the course ID
        $validated['id'] = Str::uuid();

        // Create the course record in the database
        $course = Course::create($validated);

        // Return a JSON response indicating success
        return response()->json([
            'message' => 'Course created successfully',
            'data'    => $course
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
