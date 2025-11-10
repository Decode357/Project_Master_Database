<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BackstampsTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'A12', 
                'Azure Gold', 
                'Leo', 
                'IKEA', 
                'Active', 
                'No', 
                'TRUE', 
                'No', 
                'TRUE', 
                'No', 
                '2024-01-01'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Backstamp Code',
            'Name',
            'Requestor',
            'Customer',
            'Status',
            'Organic',
            'In Glaze',
            'On Glaze',
            'Under Glaze',
            'Air Dry',
            'Approval Date',
        ];
    }
}
