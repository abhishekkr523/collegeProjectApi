<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Student::select('name', 'roll_no', 'email', 'phone', 'branch', 'session')->get();
    }

    public function headings(): array
    {
        return ['Name', 'Roll No', 'Email', 'Phone', 'Branch', 'Session'];
    }
}
