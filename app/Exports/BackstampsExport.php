<?php

namespace App\Exports;

use App\Models\Backstamp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BackstampsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // ดึงข้อมูลพร้อม relations
        return Backstamp::with(['requestor', 'customer', 'status'])
            ->select(
                'backstamp_code', 
                'name', 
                'requestor_id', 
                'customer_id',
                'status_id',
                'organic',
                'in_glaze',
                'on_glaze',
                'under_glaze',
                'air_dry',
                'approval_date'
            )->get();
    }

    /**
     * Map ข้อมูลแต่ละแถว
     */
    public function map($backstamp): array
    {
        return [
            $backstamp->backstamp_code,
            $backstamp->name,
            $backstamp->requestor ? $backstamp->requestor->name : '', // ชื่อ requestor แทน id
            $backstamp->customer ? $backstamp->customer->name : '', // ชื่อ customer แทน id
            $backstamp->status ? $backstamp->status->status : '', // ชื่อ status แทน id
            $backstamp->organic,
            $backstamp->in_glaze,
            $backstamp->on_glaze,
            $backstamp->under_glaze,
            $backstamp->air_dry,
            $backstamp->approval_date,
        ];
    }

    /**
     * @return array
     */
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
