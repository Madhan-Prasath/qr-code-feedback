<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssetsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Asset::all();
    }

    public function headings(): array
    {
        return [
            'Asset ID',
            'Asset Name',
            'Location',
            'Description',
            'Asset link',
            'Created At',
            'Created By'
        ];
    }


    public function map($row): array
    {
        // $row will be a single model instance passed in to here
        return [$row->asset_id,
                $row->asset_name,
                $row->location,
                $row->description,
                $row->link,
                $row->created_at,
                $row->created_by
        ]; // add the data from the columns defined in "headings()"
    }

}
