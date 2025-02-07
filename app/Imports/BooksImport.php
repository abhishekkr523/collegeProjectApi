<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow
{
    
    public function model(array $row)
    {
        return new Book([
            'id'               => $row['id'] ?? null,
            'title'            => $row['title'],
            'author'           => $row['author'] ?? null,
            'publisher'        => $row['publisher'] ?? null,
            'publication_year' => $row['publication_year'] ?? null,
            'isbn'             => $row['isbn'] ?? null,
            'number_of_pages'  => $row['number_of_pages'] ?? null,
            'status'           => $row['status'] ?? 'available' ?? null,
        ]);
    }
}
