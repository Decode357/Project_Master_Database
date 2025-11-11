<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class GlazesTemplateExport implements FromArray, WithHeadings, WithColumnFormatting
{
    public function array(): array
    {
        return [
            ['L2', 
            'GIS725', 
            'GOS230', 
            'Spray', 
            'Active',
            '1230',   
            '2024-01-01'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Glaze Code',
            'Glaze Inside Code',
            'Glaze Outside Code',
            'Effect Name',
            'Status',
            'Fire Temperature (°C.)',   
            'Approval Date',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Glaze Code เป็น Text
            'B' => NumberFormat::FORMAT_TEXT, // Glaze Inside Code เป็น Text
            'C' => NumberFormat::FORMAT_TEXT, // Glaze Outside Code เป็น Text
            'D' => NumberFormat::FORMAT_TEXT, // Effect Name เป็น Text
            'E' => NumberFormat::FORMAT_TEXT, // Status เป็น Text
            'F' => NumberFormat::FORMAT_TEXT, // Fire Temperature เป็น Text
            'G' => NumberFormat::FORMAT_DATE_YYYYMMDD2, // Approval Date
        ];
    }
}
