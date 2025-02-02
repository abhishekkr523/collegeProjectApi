<?php

namespace App\Http\Resources\Marks;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'total_marks' => $this->total_marks,
            'midterm_marks' => $this->midterm_marks,
            'assignment_marks' => $this->assignment_marks,
            'student_id' => $this->student_id,
            'year_id' => $this->year_id,
            'sem_id' => $this->sem_id,
            // Include related student details
            'student' => [
                'id' => $this->student->id ?? null,
                'name' => $this->student->name ?? null,
                'roll_no' => $this->student->roll_no ?? null,
                'phone' => $this->student->phone ?? null,
                'branch' => $this->student->branch ?? null,
                'session' => $this->student->session ?? null,
            ],
            // Include year details
            'year' => [
                'id' => $this->year->id ?? null,
                'year_name' => $this->year->year_name ?? null,
            ],

            // Include semester details
            'semester' => [
                'id' => $this->semester->id ?? null,
                'semester_name' => $this->semester->semester_name ?? null,
            ],
        ];
    }
}
