<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|string|exists:students,id', // Must be a valid student ID
            'custom_text' => 'nullable|string|max:500', // Optional, max 500 characters
            'book_name' => 'required|string|max:255', // Required book name
            'issue_date' => 'required|date', // Must be a valid date
            'return_date' => 'required|date|after:issue_date', // Must be after issue_date
            'subject' => 'nullable|string|max:255', // Optional subject
            'fine' => 'nullable|string|min:0',// Optional, must be non-negative
        ];
    }
}
