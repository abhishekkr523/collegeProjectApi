<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; // Assuming you have a `Student` model
use Illuminate\Support\Str; 
class StudentController extends Controller
{

//     public function index(Request $request)
// {
//     // Retrieve query parameters
//     $session = $request->query('session');
//     $branch = $request->query('branch');
//     $roll_no = $request->query('roll_no');

//     // Query students with filters
//     $query = Student::with(['semesters']);

//     if ($session) {
//         $query->where('session', $session);
//     }

//     if ($branch) {
//         $query->where('branch', $branch);
//     }

//     if ($roll_no) {
//         $query->where('roll_no', $roll_no);
//     }

//     // Fetch filtered students
//     $students = $query->get();

//     return response()->json([
//         'success' => true,
//         'message' => 'Students retrieved successfully.',
//         'students' => $students
//     ], 200);
// }
// public function index(Request $request)
// {
//     $query = Student::with(['semesters.subjects']);

//     // Apply filters if provided
//     if ($request->has('session')) {
//         $query->where('session', $request->session);
//     }

//     if ($request->has('branch')) {
//         $query->where('branch', $request->branch);
//     }

//     if ($request->has('roll_no')) {
//         $query->where('roll_no', $request->roll_no);
//     }

//     if ($request->has('semester_id')) {
//         $query->whereHas('semesters', function ($q) use ($request) {
//             $q->where('semesters.id', $request->semester_id); // 👈 FIXED: Specify table name
//         });
//     }

//     if ($request->has('subject_id')) {
//         $query->whereHas('semesters.subjects', function ($q) use ($request) {
//             $q->where('subjects.id', $request->subject_id); // 👈 FIXED: Specify table name
//         });
//     }

//     $students = $query->get();

//     return response()->json([
//         'success' => true,
//         'message' => 'Students retrieved successfully.',
//         'students' => $students
//     ], 200);
// }
public function index(Request $request)
{
    $query = Student::with(['semesters.subjects']);

    // Apply filters if provided
    if ($request->has('session')) {
        $query->where('session', $request->session);
    }

    if ($request->has('branch')) {
        $query->where('branch', $request->branch);
    }

    if ($request->has('roll_no')) {
        $query->where('roll_no', $request->roll_no);
    }

    if ($request->has('semester_id')) {
        $query->whereHas('semesters', function ($q) use ($request) {
            $q->where('semesters.id', $request->semester_id);
        });
    }

    if ($request->has('subject_id')) {
        $query->whereHas('semesters.subjects', function ($q) use ($request) {
            $q->where('subjects.id', $request->subject_id);
        });
    }

    if ($request->has('attendance_status')) {
        $query->whereHas('attendances', function ($q) use ($request) {
            $q->where('attendance_status', $request->attendance_status);
        });
    }

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
            'id'=> Str::uuid(),
            'name' => $request->name,
            'roll_no' => $request->roll_no,
            'phone' => $request->phone,
            'branch' => $request->branch,
            'session' => $request->session,
        ]);
        
        // Create a new student
        $student = Student::create($request->all());

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
