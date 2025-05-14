<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Semester;
use App\Models\Attendance;
use App\Models\StudentSubject;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the attendance records.
     */
    public function index()
    {
        return response()->json(Attendance::with(['student', 'semester', 'subject'])->get(), 200);
    }

    /**
     * Store a new attendance record.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'student_id' => 'required|exists:students,id',
    //         'semester_id' => 'required|exists:semesters,id',
    //         'subject_id' => 'required|exists:subjects,id',
    //         'attendance_status' => 'required|in:present,absent,late',
    //         'date' => 'required|date_format:d/m/Y', // Validate input format
    //     ]);

    //     // Convert date format from `d/m/Y` (12/12/2023) to `Y-m-d` (2023-12-12)
    //     $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');


    //     // Ensure student-semester relationship exists in `student_semester` table
    //     $student = Student::find($request->student_id);
    //     if (!$student->semesters->contains($request->semester_id)) {
    //         $student->semesters()->attach($request->semester_id);
    //     }

    //     $attendance = Attendance::create([
    //         'student_id' => $request->student_id,
    //         'semester_id' => $request->semester_id,
    //         'subject_id' => $request->subject_id,
    //         'attendance_status' => $request->attendance_status,
    //         'date' => $formattedDate, // Store in correct format
    //     ]);

    //     return response()->json(['message' => 'Attendance recorded successfully', 'attendance' => $attendance], 201);
    // }
    public function store(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'session'=>'required',
        //     'branch'=>'required',
        //     'student_id' => 'required|exists:students,id',
        //     'semester_id' => 'required|exists:semesters,id',
        //     'subject_id' => 'required|exists:subjects,id',
        //     'attendance_status' => 'required|in:present,absent,late',
        //     'date' => 'required|date_format:d/m/Y', // Validate input format
        // ]);

        // Convert date format from `d/m/Y` (12/12/2023) to `Y-m-d` (2023-12-12)
        $userId = auth()->user()->id;
        $dateString = trim($request->date); // Remove whitespace
        $formattedDate = Carbon::createFromFormat('d/m/Y', $dateString)->format('Y-m-d');


        $student = Student::findOrFail($request->student_id);
        if (!$student->subjects->contains($request->subject_id)) {
            StudentSubject::create([
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id
            ]);
        }


        // Check if attendance already exists for this student, semester, subject and date
        $existingAttendance = Attendance::where('student_id', $request->student_id)
            ->where('semester_id', $request->semester_id)
            ->where('subject_id', $request->subject_id)
            ->where('date', $formattedDate)
            ->exists();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance for this student, subject, and date already exists.',
            ], 409); // HTTP 409 Conflict
        }
        // Create new attendance record
        $attendance = Attendance::create([
            'student_id' => $request->student_id,
            'semester_id' => $request->semester_id,
            'subject_id' => $request->subject_id,
            'attendance_status' => $request->attendance_status,
            'date' => $formattedDate, // Store in correct format
            'taken_by' => $userId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance recorded successfully',
            'attendance' => $attendance,
        ], 201);
    }



    /**
     * Display a specific attendance record.
     */
    public function show($id)
    {
        $attendance = Attendance::with(['student', 'semester', 'subject'])->find($id);

        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }

        return response()->json($attendance, 200);
    }

    /**
     * Update an existing attendance record.
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }

        $request->validate([
            'student_id' => 'sometimes|exists:students,id',
            'semester_id' => 'sometimes|exists:semesters,id',
            'subject_id' => 'sometimes|exists:subjects,id',
            'attendance_status' => 'sometimes|in:present,absent,late',
            'date' => 'sometimes|date',
        ]);

        $attendance->update($request->all());

        return response()->json(['message' => 'Attendance updated successfully', 'attendance' => $attendance], 200);
    }

    /**
     * Remove an attendance record.
     */
    public function destroy($id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }

        $attendance->delete();

        return response()->json(['message' => 'Attendance deleted successfully'], 200);
    }
    // public function getAttendanceBySemesterAndSubject(Request $request): array
    // {
    //     $email = $request->query('email'); // or $request->email if you're using POST/Body

    //     // Find student by email
    //     $student = Student::where('email', $email)->first();

    //     $studentId = $student->id;

    //     // Get all attendances for the student
    //     $attendances = Attendance::with(['semester', 'subject'])
    //         ->where('student_id', $studentId)
    //         ->orderBy('date')
    //         ->get();

    //     $grouped = [];

    //     foreach ($attendances as $attendance) {
    //         $semesterName = $attendance->semester->name; // assuming 'name' exists
    //         $subjectName = $attendance->subject->name;   // assuming 'name' exists

    //         // Initialize arrays if not already
    //         if (!isset($grouped[$semesterName])) {
    //             $grouped[$semesterName] = [];
    //         }
    //         if (!isset($grouped[$semesterName][$subjectName])) {
    //             $grouped[$semesterName][$subjectName] = [];
    //         }

    //         $grouped[$semesterName][$subjectName][] = [
    //             $attendance->date,
    //             $attendance->attendance_status
    //         ];
    //     }

    //     return $grouped;
    // }
    public function getAttendanceBySemesterAndSubject($email)
{
    if (!$email) {
        return response()->json([
            'message' => 'Email is required'
        ], 400);
    }

    $student = Student::where('email', $email)->first();

    if (!$student) {
        return response()->json([
            'message' => 'Student not found'
        ], 404);
    }

    $studentId = $student->id;

    // Get all attendances for the student
    $attendances = Attendance::with(['semester', 'subject'])
        ->where('student_id', $studentId)
        ->orderBy('date')
        ->get();

    $grouped = [];

    foreach ($attendances as $attendance) {
        $semesterName = Semester::find($attendance->semester_id)->semester_name ?? 'Unknown Semester';
        $subjectName = Subject::find($attendance->subject_id)->name ?? 'Unknown Subject';

        // Initialize arrays if not already
        if (!isset($grouped[$semesterName])) {
            $grouped[$semesterName] = [];
        }
        if (!isset($grouped[$semesterName][$subjectName])) {
            $grouped[$semesterName][$subjectName] = [];
        }

        $grouped[$semesterName][$subjectName][] = [
            'date' => $attendance->date,
            'status' => $attendance->attendance_status
        ];
    }

    return response()->json($grouped);
}
}
