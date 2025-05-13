<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendMailRequest;
use App\Mail\IssueMail;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendIssueEmail;

class SendMailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $student_parent_email = $request['student_parent_email']?? ''; // Array-like syntax
        $issue = $request['issue'] ?? ''; // Default issue
        $subject = $request['subject'] ?? ''; // Subject of the mail
        $sender = $request['sender'] ?? ''; // Sender of the mail
        // Send the email using Mailable
        SendIssueEmail::dispatch($student_parent_email,$sender,$issue,$subject);
        return response()->json(['message' => 'Email notification sent successfully!'], 200);
    }
    
}
