<?php

namespace App\Exports;

use App\Models\Notice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class NoticesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Select only the specified columns
        return Notice::select('title', 'description', 'category', 'author', 'notice_date', 'file')->get();
    }

    /**
     * Map the data for each notice.
     *
     * @param \App\Models\Notice $notice
     * @return array
     */
    public function map($notice): array
    {
        return [
            $notice->title,
            $notice->description,
            $notice->category,
            $notice->author,
            $notice->notice_date,
            $notice->file,
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
            'Title',
            'Description',
            'Category',
            'Author',
            'Notice Date',
            'File',
        ];
    }
}
