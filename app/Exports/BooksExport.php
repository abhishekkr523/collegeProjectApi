<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class BooksExport implements FromCollection,WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Book::select(
            'id',
            'title',
            'author',
            'publisher',
            'publication_year',
            'isbn',
            'number_of_pages',
            'status',
        )->get();
    }

    public function map($book): array
    {
        return [
            $book->id,
            $book->title,
            $book->author,
            $book->publisher,
            $book->publication_year,
            $book->isbn,
            $book->number_of_pages,
            $book->status,
        ];
    }

    /**
     * Define the headings for the exported file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id',
            'Title',
            'Author',
            'Publisher',
            'Publication Year',
            'ISBN',
            'Number of Pages',
            'Status',
        ];
    }
}
