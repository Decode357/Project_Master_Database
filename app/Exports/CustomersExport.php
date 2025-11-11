<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CustomersExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // เลือกเฉพาะคอลัมน์ที่ต้องการ
        return Customer::select('code', 'name', 'email', 'phone')->get();
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