<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; // Assuming you have a `Student` model
use Carbon\Carbon;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $query = Student::with(['semesters', 'attendances', 'subjects']);
        // Apply filters if provided
        // if ($request->filled('date')) {

        //     $query->whereHas('attendances', function ($q) use ($request) {
        //         $cleanDate = preg_replace('/\s*\(.*\)$/', '', $request->date);
        //         // Step 2: Parse it into Carbon
        //         $formattedDate = Carbon::parse($cleanDate)->format('Y-m-d');

        //         $q->where('date', $formattedDate);
        //     });
        // }
        // if ($request->filled('attendance_status')) {
        //     $query->whereHas('attendances', function ($q) use ($request) {
        //         $q->where('attendances.attendance_status', $request->attendance_status);
        //     });
        // }
        if ($request->filled('date') || $request->filled('attendance_status')) {
            $query->whereHas('attendances', function ($q) use ($request) {
                if ($request->filled('date')) {
                    $cleanDate = preg_replace('/\s*\(.*\)$/', '', $request->date);
                    $formattedDate = Carbon::parse($cleanDate)->format('Y-m-d');
                    $q->where('date', $formattedDate);
                }

                if ($request->filled('attendance_status')) {
                    $q->where('attendance_status', $request->attendance_status);
                }
            });
        }
        // return $query->get();
        if ($request->filled('session')) {
            $query->where('session', $request->session);
        }

        if ($request->filled('branch')) {
            $query->where('branch', $request->branch);
        }

        if ($request->filled('roll_no')) {
            $query->where('roll_no', $request->roll_no);
        }

        if ($request->filled('semester_id')) {
            $query->whereHas('semesters', function ($q) use ($request) {
                $q->where('semesters.id', $request->semester_id);
            });
        }

        // if ($request->filled('subjects_id')) {
        //     // Ensures only students with subjects are included
        //     $query->whereHas('subjects', function ($q) use ($request) {
        //         $q->where('subjects.id', $request->subjects_id);
        //     });
        // }
        // ✅ Filter students who have at least one attendance with the given status

        $students = $query->get();

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
            'id' => Str::uuid(),
            'name' => $request->name,
            'roll_no' => $request->roll_no,
            'phone' => $request->phone,
            'branch' => $request->branch,
            'session' => $request->session,
        ]);

        // Create a new student
        // $student = Student::create($request->all());

        return response()->json(['message' => 'Student created successfully', 'student' => $student], 200);
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
