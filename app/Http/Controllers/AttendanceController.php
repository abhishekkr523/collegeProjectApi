<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
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
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'subject_id' => 'required|exists:subjects,id',
            'attendance_status' => 'required|in:present,absent,late',
            'date' => 'required|date',
        ]);

        $attendance = Attendance::create($request->all());

        return response()->json(['message' => 'Attendance recorded successfully', 'attendance' => $attendance], 201);
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
}
