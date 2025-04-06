<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendMailRequest;
use App\Mail\BookIssueMail;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // dd($request->all());
        // Get student ID from request or default to 1
        $student = Student::find($request['student_id']?? ''); // Array-like syntax
        // Prepare email data from validated request
        $studentName = $student->name;
        $bookName = $request['book_name']; // Array-like syntax
        $issueDate = $request['issue_date'];
        $returnDate = $request['return_date'];
        $subject = $request['subject'] ?? 'Your Book Issue Notification'; // Default subject
        $fine = $request['fine'];
        $customText = $request['custom_text'];
        // Send the email using Mailable
        Mail::to($student->email)->send(new BookIssueMail($studentName, $bookName, $issueDate, $returnDate, $fine, $customText,$subject));

        return response()->json(['message' => 'Email notification sent successfully!'], 200);
    }
    
}
