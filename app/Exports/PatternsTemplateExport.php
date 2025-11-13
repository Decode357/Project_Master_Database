<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class PatternsTemplateExport implements FromArray, WithHeadings, WithColumnFormatting
{
    public function array(): array
    {
        return [
            [
            '85PM', 
            'Example Pattern', 
            'Active', 
            'IKEA', 
            'John Doe', 
            'Jane Smith', 
            'Yes', 
            'No', 
            'No', 
            'Yes', 
            '2024-01-01'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Pattern Code',
            'Pattern Name',
            'Status',
            'Customer',
            'Requestor',
            'Designer',
            'In Glaze',
            'On Glaze',
            'Under Glaze',
            'Exclusive',
            'Approval Date',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Pattern Code
            'B' => NumberFormat::FORMAT_TEXT, // Name
            'C' => NumberFormat::FORMAT_TEXT, // Status
            'D' => NumberFormat::FORMAT_TEXT, // Customer Name
            'E' => NumberFormat::FORMAT_TEXT, // Requestor
            'F' => NumberFormat::FORMAT_TEXT, // Designer
            'K' => NumberFormat::FORMAT_DATE_YYYYMMDD2, // Approval Date
        ];
    }
}
