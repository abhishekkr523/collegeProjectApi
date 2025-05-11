<?php

namespace App;

use App\Mail\IssueMail;
use App\Models\Book;
use App\Models\Student;
use App\Notifications\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendIssueEmail;

trait EmailNotificationTrait
{
    public function sendEmail( $userId= null,$bookName = null,$issueDate = null,$returnDate = null,$fine = null, $customText = null, $subject = null)
    {
        // Find the user (default to ID 1 if not provided, or use request data)
        $student = Student::find($userId); // You can modify this logic as needed
        if (!$student) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Use provided custom text or a default message
        $message = $customText ?? 'This is a default message';

        // Dispatch the email job to the queue
        SendIssueEmail::dispatch($student, $message,$subject);

        return response()->json(['message' => 'Email notification sent successfully!']);
    }
}
