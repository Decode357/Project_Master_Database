<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ShapesTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            // ['a1b2c34', 
            // 'ไทย', 
            // 'English', 
            // 'Bone', 
            // 'Active', 
            // 'Z19', 
            // 'IKEA', 
            // 'Cup & Saucer', 
            // 'glaze', 
            // 'Bob', 
            // 'Alice', 
            // '99', 
            // '150', 
            // '23.98', 
            // '11.1', 
            // '34', 
            // '44', 
            // '1.2', 
            // '2024-01-01'
            // ]
        ];
    }

    public function headings(): array
    {
        return [
            'Item Code',
            'Description Thai',
            'Description Eng',
            'Type',
            'Status',
            'Collection Code',
            'Customer',
            'Item Group',
            'Process',
            'Designer',
            'Requestor',
            'Volume',
            'Weight',
            'Long Diameter',
            'Short Diameter',
            'Height Long',
            'Height Short',
            'Body',
            'Approval Date',
        ];
    }
    /**
     * กำหนด format ของแต่ละ column
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Item Code เป็น Text
            'B' => NumberFormat::FORMAT_TEXT, // Description Thai เป็น Text
            'C' => NumberFormat::FORMAT_TEXT, // Description Eng เป็น Text
            'D' => NumberFormat::FORMAT_TEXT, // Type เป็น Text
            'E' => NumberFormat::FORMAT_TEXT, // Status เป็น Text
            'F' => NumberFormat::FORMAT_TEXT, // Collection Code เป็น Text
            'G' => NumberFormat::FORMAT_TEXT, // Customer Name เป็น Text
            'H' => NumberFormat::FORMAT_TEXT, // Item Group เป็น Text
            'I' => NumberFormat::FORMAT_TEXT, // Process เป็น Text
            'J' => NumberFormat::FORMAT_TEXT, // Designer เป็น Text
            'K' => NumberFormat::FORMAT_TEXT, // Requestor เป็น Text
            'S' => NumberFormat::FORMAT_DATE_YYYYMMDD2, // Approval Date
        ];
    }
}
