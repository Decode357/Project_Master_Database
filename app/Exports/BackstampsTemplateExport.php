<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BackstampsTemplateExport implements FromArray, WithHeadings, WithColumnFormatting
{
    public function array(): array
    {
        return [
            [
                // 'A12', 
                // 'Azure Gold', 
                // 'Leo', 
                // 'IKEA', 
                // 'Active', 
                // 'No', 
                // 'TRUE', 
                // 'No', 
                // 'TRUE', 
                // 'No', 
                // '2024-01-01'
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

    /**
     * กำหนด format ของแต่ละ column
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Backstamp Code
            'B' => NumberFormat::FORMAT_TEXT, // Name
            'C' => NumberFormat::FORMAT_TEXT, // Requestor
            'D' => NumberFormat::FORMAT_TEXT, // Customer
            'E' => NumberFormat::FORMAT_TEXT, // Status
            'K' => NumberFormat::FORMAT_DATE_YYYYMMDD2, // Approval Date
        ];
    }
}
