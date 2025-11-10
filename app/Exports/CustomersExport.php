<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
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
}