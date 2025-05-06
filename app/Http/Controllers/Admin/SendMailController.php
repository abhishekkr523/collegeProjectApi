<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendMailRequest;
use App\Mail\IssueMail;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $student_email = $request['student_email']?? ''; // Array-like syntax
        $subject = $request['subject'] ?? 'Notification'; // Default subject
        $issue = $request['issue'] ?? ''; // Default issue
        $student_name = $request['student_name'] ?? ''; // Default issue
        $sender = $request['sender'] ?? ''; // Default issue
        // Send the email using Mailable
        Mail::to($student_email)->send(new IssueMail($student_name,$subject, $issue,$sender));
        return response()->json(['message' => 'Email notification sent successfully!'], 200);
    }
    
}
