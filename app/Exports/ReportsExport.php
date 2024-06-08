<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Report::all();
    }

    public function headings(): array
    {
        return [
            'Asset ID',
            'Asset Name',
            'Asset Location',
            'Feedback',
            'Created At',
            'Created By',
            'Status',
        ];
    }


    public function map($row): array
    {
        // $row will be a single model instance passed in to here
        return [$row->assets->asset_id,
                $row->assets->asset_name,
                $row->assets->location,
                $row->feedback,
                $row->created_at,
                $row->created_by,
                $row->status
        ]; // add the data from the columns defined in "headings()"
    }
}
