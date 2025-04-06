<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    // 📌 1. Get all subjects
    public function index()
    {
        $subjects = Subject::all();

        return response()->json([
            'success' => true,
            'message' => 'Subjects retrieved successfully.',
            'data' => $subjects
        ], Response::HTTP_OK);
    }

    // 📌 2. Create a new subject
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:subjects|string|max:255',
            'code' => 'required|unique:subjects|string|max:50',
            'credits' => 'required|integer|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $subject = Subject::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => $request->name,
            'code' => $request->code,
            'credits' => $request->credits,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subject created successfully.',
            'data' => $subject
        ], Response::HTTP_CREATED);
    }

    // 📌 3. Get a single subject by ID
    public function show($id)
    {
        $subject = Subject::find($id);

        if (!$subject) {
            return response()->json(['success' => false, 'message' => 'Subject not found.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Subject retrieved successfully.',
            'data' => $subject
        ], Response::HTTP_OK);
    }

    // 📌 4. Update a subject
    public function update(Request $request, $id)
    {
        $subject = Subject::find($id);

        if (!$subject) {
            return response()->json(['success' => false, 'message' => 'Subject not found.'], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:subjects,name,' . $id,
            'code' => 'required|string|max:50|unique:subjects,code,' . $id,
            'credits' => 'required|integer|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $subject->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Subject updated successfully.',
            'data' => $subject
        ], Response::HTTP_OK);
    }

    // 📌 5. Delete a subject
    public function destroy($id)
    {
        $subject = Subject::find($id);

        if (!$subject) {
            return response()->json(['success' => false, 'message' => 'Subject not found.'], Response::HTTP_NOT_FOUND);
        }

        $subject->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subject deleted successfully.'
        ], Response::HTTP_OK);
    }
}

