<?php

namespace App\Http\Requests\Marks;

use Illuminate\Foundation\Http\FormRequest;

class MarksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject' => 'string|max:255',
            'total_marks' => 'integer',
            'midterm_marks' => 'integer',
            'assignment_marks' => 'integer',
            'student_id' => 'exists:students,id',
            'year_id' => 'exists:years,id',
            'sem_id' => 'exists:semesters,id',
        ];
    }
}
