<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class StudentsImport implements ToModel
{
    public function model(array $row)
    {
         if (count($row) < 8) {
        return null; // skip this row
    }
        return new Student([
            'name' => $row[0],
            'roll_no' => $row[1],
            'email' => $row[2],
            'phone' => $row[3],
            'branch' => $row[4],
            'session' => $row[5],
            'parent_email' => $row[6],
            'parent_phone' => $row[7],
        ]);
    }
}
