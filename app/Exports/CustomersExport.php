<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CustomersExport implements FromQuery, WithHeadings, WithColumnFormatting
{
    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Customer::select('code', 'name', 'email', 'phone');
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Email',
            'Phone',
        ];
    }

    /**
     * กำหนด format ของแต่ละ column
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Code
            'B' => NumberFormat::FORMAT_TEXT, // Name
            'C' => NumberFormat::FORMAT_TEXT, // Email
            'D' => NumberFormat::FORMAT_TEXT, // Phone
        ];
    }
}