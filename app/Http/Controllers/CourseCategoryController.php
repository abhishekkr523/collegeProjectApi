<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $courseCate= CourseCategory::all();
        return response()->json([
            'success' => true,
            'message' => 'Course Category retrieved successfully.',
            'data' => $courseCate
        ], 200);
    }
    public function show($category_id)
    {
        // Attempt to find the category by ID
        $category = CourseCategory::find($category_id);

        // If not found, return a 404 error
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Return the found category
        return response()->json($category);
    }
}
