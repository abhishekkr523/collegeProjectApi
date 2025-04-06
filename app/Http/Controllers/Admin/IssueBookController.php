<?php

namespace App\Http\Controllers\Admin;

use App\EmailNotificationTrait;
use App\Http\Controllers\Controller;
use App\Models\Admin\IssueBook;
use App\Models\Book;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IssueBookController extends Controller
{
    use EmailNotificationTrait;
    public function index(Request $request)
    {

        // Build the query to include the student and book relationships
        $query = IssueBook::with(['student', 'book']);
        if ($request->has('student_id') && !empty($request->student_id)) {
            $query->where('student_id', $request->student_id); // Execute the query and get the results
            $issues = $query->get();
            return response()->json([
                'data' => $issues,
                'message' => 'Issue records retrieved successfully.'
            ], 200);
        }
    }
    public function findStudent(Request $request)
    {
        $query = Student::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('roll_no', 'LIKE', '%' . $request->search . '%')
                ->orWhere('name', 'LIKE', '%' . $request->search . '%');
        }

        $students = $query->get(); // Fetch all matching students

        if ($students->isNotEmpty()) {
            $studentsData = $students->map(function ($student) {
                // Get all issued books for the student
                $issuedBooks = IssueBook::where('student_id', $student->id)
                    ->with('book')
                    ->get();

                // Filter returned and pending books
                $returnedBooks = $issuedBooks->where('status', 'returned')->count();
                $pendingBooks = $issuedBooks->where('status', 'pending')->count();
                $totalIssuedBooks = $returnedBooks + $pendingBooks; // Total issued books

                $bookList = $issuedBooks->map(function ($issue) {
                    return [
                        'book_id' => $issue->book->id,
                        'book_title' => $issue->book->title,
                        'status' => $issue->status // Add book status
                    ];
                });

                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'roll_no' => $student->roll_no,
                    'total_issued_books' => $totalIssuedBooks,
                    'returned_books' => $returnedBooks,
                    'pending_books' => $pendingBooks,
                    'issued_books' => $bookList,
                ];
            });

            return response()->json([
                'message' => 'Students found',
                'students' => $studentsData
            ], 200);
        } else {
            return response()->json(['message' => 'No students found'], 200);
        }
    }


    public function checkAddingStatus(Request $request)
    {
        $isValidBookIsbn   = $request->isValidBookIsbn ?? '';

        // Look up the book only if an ISBN is provided
        $book = null;
        if (!empty($isValidBookIsbn)) {
            $book = Book::where('isbn', $isValidBookIsbn)->first();

            if (!$book) {
                return response()->json([
                    'message' => 'Book is not present',
                    'type' => 'book_isbn'
                ], 200);
            }

            // Check if the book is issued (borrowed or reserved)
            $issueStatus = Book::where('id', $book->id)
                ->whereIn('status', ['reserved', 'borrowed', 'available']) // Check for reserved or borrowed status
                ->first();

            if ($issueStatus->status == 'reserved' || $issueStatus->status == 'borrowed') {
                return response()->json([
                    'message' => 'Book is currently ' . $issueStatus->status, // It will return 'reserved' or 'borrowed'
                    'type' => 'book_status'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Book is available',
                    'type' => 'book_status'
                ], 200);
            }
        }


        return response()->json(['message' => ''], 200);
    }
    // public function addingBookIssue(Request $request)
    // {
    //     // $validated = $request->validate([
    //     //     'fine'        => 'required',
    //     //     'status'      => 'required'
    //     // ]);

    //     $issue_date = Carbon::parse($request->issue_date)->format('Y-m-d H:i:s');
    //     $return_date = Carbon::parse($request->return_date)->format('Y-m-d H:i:s');
    //     $student = Student::where('roll_no', $request->roll_number)->firstOrFail();
    //     $book = Book::where('isbn', $request->book_isbn)->firstOrFail();
    //     if ($book) {
    //         if ($request->status == 'pending') {
    //             $book->status = 'reserved';
    //         }
    //         if ($request->status == 'returned') {
    //             $book->status = 'available';
    //         }
    //         $book->save();
    //     }
    //     $updateData = [
    //         'student_id'  => $student->id,
    //         'book_id'     => $book->id,
    //         'issue_date'  => $issue_date,
    //         'return_date' => $return_date,
    //         'fine'        => $request->fine,
    //         'status'      => $request->status
    //     ];

    //     $issueBook=IssueBook::create($updateData);

    //     return response()->json(['success' => true, 'message' => 'Issue book successfully Created', 'data' => $issueBook], 201);
    // }
    public function addingBookIssue(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'issue_date'   => 'required', // Must be a valid date
            'return_date'  => 'required|after:issue_date', // Must be after issue_date
            'roll_number'  => 'required|string|exists:students,roll_no', // Must exist in students table
            // 'book_isbn'    => 'required|string|exists:books,isbn', // Must exist in books table
            'fine'         => 'nullable|string', // Optional, must be a positive number
            'status'       => 'required|string|in:pending,returned' // Must be one of these values
        ]);
        // dd($validatedData);

        $validatedData['issue_date'] = Carbon::parse($request->issue_date)->format('Y-m-d H:i:s');
            $validatedData['return_date'] = Carbon::parse($request->return_date)->format('Y-m-d H:i:s');
            $student = Student::where('roll_no', $request->roll_number)->firstOrFail();
            $book = Book::where('isbn', $request->book_isbn)->firstOrFail();
            if ($book) {
                if ($request->status == 'pending') {
                    $book->status = 'reserved';
                }
                if ($request->status == 'returned') {
                    $book->status = 'available';
                }
                $book->save();
            }
            $validatedData['student_id'] = $student->id;
            $validatedData['book_id'] = $book->id;
            // dd($validatedData);
        $issueBook=IssueBook::create($validatedData);
        if($issueBook){
            $text='Book has been successfully issued.';
            $this->sendEmail($issueBook->student_id,$book->title,$issueBook->issue_date,$issueBook->return_date,$issueBook->fine,$text);
        }
        return response()->json([
            'message' => 'Book has been successfully issued.',
            'data' =>$issueBook ,
        ], 200);
    }
    public function show($id)
    {
        $issueBook = IssueBook::firstOrFail($id);

        if (!$issueBook) {
            return response()->json(['message' => 'This data is not found'], 200);
        }

        return response()->json($issueBook, 200);
    }
    
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'fine'        => 'required',
            'status'      => 'required'
        ]);

        $issue_date = Carbon::parse($request->issue_date)->format('Y-m-d H:i:s');
        $return_date = Carbon::parse($request->return_date)->format('Y-m-d H:i:s');
        $issueBook = IssueBook::find($id);
        $student = Student::where('roll_no', $request->roll_number)->firstOrFail();
        $book = Book::where('isbn', $request->book_isbn)->firstOrFail();
        if (!$issueBook) {
            return response()->json(['message' => 'This issue is not found'], 200);
        }
        if ($book) {
            if ($request->status == 'pending') {
                $book->status = 'reserved';
            }
            if ($request->status == 'returned') {
                $book->status = 'available';
            }
            $book->save();
        }
        $updateData = [
            'student_id'  => $student->id,
            'book_id'     => $book->id,
            'issue_date'  => $issue_date,
            'return_date' => $return_date,
            'fine'        => $request->fine,
            'status'      => $request->status
        ];

        $issueBook->update($updateData);

        return response()->json(['success' => true, 'message' => 'Issue book successfully updated', 'data' => $issueBook], 200);
    }

    public function destroy(string $id)
    {
        // Find the mark to delete
        $issueBook = IssueBook::find($id);
        if (!$issueBook) {
            return response()->json(['message' => 'Issue Book is not found'], 404);
        } else {
            // Get the book ID from the issued book record
            $bookId = $issueBook->book_id;

            // Find the book in the books table and update its status
            Book::where('id', $bookId)->update(['status' => 'available']);
            // Delete the issueBook entry
            $issueBook->delete();

            return response()->json(['message' => 'Mark deleted successfully']);
        }
    }
}
