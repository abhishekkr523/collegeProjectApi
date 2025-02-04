<?php

namespace App\Imports;

use App\Models\Mark;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MarksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Mark([
            'student_id' => $row['student_id'],
            'year_id' => $row['year_id'],
            'sem_id' => $row['sem_id'],
            'subject' => $row['subject'],
            'midterm_marks' => $row['midterm_marks'],
            'total_marks' => $row['total_marks'],
            'assignment_marks' => $row['assignment_marks'],
        ]);
    }
}
