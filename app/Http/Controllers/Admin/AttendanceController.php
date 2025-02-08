<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Attendance;
use App\Models\Admin\Classe;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date');
        $class_id = $request->input('class_id');
    
        $query = DB::table('students')
            ->leftJoin('attendances', function ($join) use ($date, $class_id) {
                $join->on('students.id', '=', 'attendances.student_id');
                if ($date) {
                    $join->where('attendances.attendance_date', '=', $date);
                }
                if ($class_id) {
                    $join->where('attendances.class_id', '=', $class_id);
                }
            })
             ->leftJoin('classes', 'attendances.classe_id', '=', 'classes.id')
             ->select(
                'students.*',
                DB::raw("IFNULL(attendances.status, 'absent') as attendance_status"),
                'attendances.attendance_date'
            );
    
        $data = $query->get();
    
        return response()->json([
            'status'   => true,
            'students' => $data
        ], 200);
    }
    public function store(Request $request)
    {
        // Validate the incoming data.
        $validated = $request->validate([
            'student_id'      => 'required|exists:students,id',
            'class_id'        => 'required|exists:classes,id',
            'semester_id'     =>'required|exists:semesters,id',
            'attendance_date' => 'required|date',
            'status'          => 'required|in:present,absent,excused'
        ]);

        // Retrieve the student.
        $student = Student::findOrFail($validated['student_id']);

        // Ensure the student is assigned to a class.
        if (!$student->classe_id) {
            return response()->json([
                'status'  => false,
                'message' => 'Student is not assigned to any class.'
            ], 422);
        }

        // Assign the class_id from the student's record.
        $validated['classe_id'] = $student->class_id;

        // Create the attendance record.
        $attendance = Attendance::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Attendance record created successfully',
            'data'    => $attendance
        ], 201);
    }


    // Show the form to edit a specific attendance record
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('admin.attendance.edit', compact('attendance'));
    }

    // Update an attendance record
    public function update(Request $request, $id)
    {
       // Validate the input.
        // Each attendance status must be one of the allowed values.
        $request->validate([
            'class_id'        => 'required|integer',
            'date'            => 'required|date',
            'attendance.*'    => 'required|in:present,absent,excused'
        ]);

        $class_id = $request->input('class_id');
        $date = $request->input('date');
        $attendances = $request->input('attendance'); // Array: student_id => status

        // Loop through each student attendance entry.
        foreach ($attendances as $student_id => $status) {
            // Update the record if it exists, or create a new one otherwise.
            Attendance::updateOrCreate(
                [
                    'student_id'      => $student_id,
                    'class_id'        => $class_id,
                    'attendance_date' => $date,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return response()->json([
            'status'   => true,
            'message' => "Updated Successfully"
        ], 200);;
    }
}
