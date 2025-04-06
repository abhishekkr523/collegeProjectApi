<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Get all courses with their categories.
     */
    public function index()
    {
        return response()->json(Course::with('categories')->get());
    }

    /**
     * Store a new course.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'duration' => 'required|integer',
            'instructor' => 'required|string',
            'credits' => 'integer',
            'fee' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:course_categories,id'
        ]);

        $course = Course::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'instructor' => $request->instructor,
            'credits' => $request->credits ?? 3,
            'fee' => $request->fee,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        $course->categories()->attach($request->category_ids);

        return response()->json(['message' => 'Course created successfully', 'course' => $course], 201);
    }

    /**
     * Get a specific course with its categories.
     */
    public function show($id)
    {
        $course = Course::with('categories')->findOrFail($id);
        return response()->json($course);
    }

    /**
     * Update a course.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'duration' => 'required|integer',
            'instructor' => 'required|string',
            'credits' => 'integer',
            'fee' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:course_categories,id'
        ]);

        $course->update($request->only([
            'name', 'description', 'duration', 'instructor', 'credits', 'fee', 'start_date', 'end_date'
        ]));

        $course->categories()->sync($request->category_ids);

        return response()->json(['message' => 'Course updated successfully', 'course' => $course]);
    }

    /**
     * Delete a course.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->categories()->detach(); // Remove relationships first
        $course->delete();

        return response()->json(['message' => 'Course deleted successfully']);
    }
}
