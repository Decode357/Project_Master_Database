<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['CUST001', 'Example Customer', 'example@email.com', '0812345678']
        ];
    }

    public function headings(): array
    {
        return [
            'code',
            'name',
            'email',
            'phone',
        ];
    }
}