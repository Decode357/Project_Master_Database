<?php

namespace App\Exports;

use App\Models\Pattern;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PatternsExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // ใช้ชื่อ relationship ที่ถูกต้อง (camelCase)
        return Pattern::with(['status', 'customer', 'requestor', 'designer'])
            ->select(
                'pattern_code',
                'pattern_name',
                'status_id',
                'customer_id',
                'requestor_id',
                'designer_id',
                'in_glaze',
                'on_glaze',
                'under_glaze',
                'exclusive',
                'approval_date',
            )->get();
    }

    /**
     * Map ข้อมูลแต่ละแถว
     */
    public function map($pattern): array
    {
        return [
            $pattern->pattern_code,
            $pattern->pattern_name,
            $pattern->status ? $pattern->status->status : '', 
            $pattern->customer ? $pattern->customer->name : '', 
            $pattern->requestor ? $pattern->requestor->name : '', 
            $pattern->designer ? $pattern->designer->designer_name : '', 
            $pattern->in_glaze,
            $pattern->on_glaze,
            $pattern->under_glaze,
            $pattern->exclusive,
            $pattern->approval_date ? $pattern->approval_date->format('Y-m-d') : '',
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Pattern Code',
            'Name',
            'Status',
            'Customer Name',
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
