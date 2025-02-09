<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\IssueBook;
use App\Models\Book;
use App\Models\Student;
use Illuminate\Http\Request;

class IssueBookController extends Controller
{
    public function index(Request $request)
    {
        $rollNumber = $request->roll_number;

    // Build the query to include the student and book relationships
    $query = IssueBook::with(['student', 'book']);
    if ($rollNumber) {
        $query->whereHas('student', function ($q) use ($rollNumber) {
            $q->where('roll_no', $rollNumber);
        });
    }

    // Execute the query and get the results
    $issues = $query->get();
        return response()->json([
            'data' => $issues,
            'message' => 'Issue records retrieved successfully.'
        ], 200);
    }

    public function addingBookIssue(Request $request)
    {
         // Validate that the required IDs are provided and exist
         $validated = $request->validate([
            'book_id'  => 'required|exists:books,id',
            'issue_date' => 'required|date',
            'return_date' => 'required|date',
            'fine'        =>'required'
        ]);
         // Look up the student using the provided roll number
  $student = Student::where('roll_no', $request->roll_number)->firstOrFail();
  // Now you have the student id
  $validated['student_id'] = $student->id;
        $issueBook=IssueBook::create($validated);
        return response()->json([
            'message' => 'Book has been successfully issued.',
            'data' =>$issueBook ,
        ], 200);
    }
}
