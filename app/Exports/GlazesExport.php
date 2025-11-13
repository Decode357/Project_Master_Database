<?php

namespace App\Exports;

use App\Models\Glaze;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class GlazesExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting
{
    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        // ใช้ชื่อ relationship ที่ถูกต้อง (camelCase)
        return Glaze::with(['glazeInside', 'glazeOuter', 'effect', 'status'])
            ->select(
                'glaze_code', 
                'glaze_inside_id', 
                'glaze_outer_id',
                'effect_id',
                'status_id',
                'fire_temp',
                'approval_date'
            );
    }

    public function map($glaze): array
    {
        return [
            $glaze->glaze_code,
            $glaze->glazeInside ? $glaze->glazeInside->glaze_inside_code : '', 
            $glaze->glazeOuter ? $glaze->glazeOuter->glaze_outer_code : '', 
            $glaze->effect ? $glaze->effect->effect_name : '', 
            $glaze->status ? $glaze->status->status : '', 
            $glaze->fire_temp,
            $glaze->approval_date ? $glaze->approval_date->format('Y-m-d') : '',
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Glaze Code',
            'Glaze Inside Code',
            'Glaze Outside Code',
            'Effect Name',
            'Status',
            'Fire Temperature (°C)',   
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
