<?php

namespace App\Exports;

use App\Models\Shape;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ShapesExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting
{
    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Shape::with([
                'shapeType', 
                'status', 
                'shapeCollection', 
                'customer',  
                'itemGroup', 
                'process', 
                'designer', 
                'requestor'
            ])
            ->select(
                'item_code',
                'item_description_thai',
                'item_description_eng',
                'shape_type_id',
                'status_id',
                'shape_collection_id',
                'customer_id',
                'item_group_id',
                'process_id',
                'designer_id',
                'requestor_id',
                'volume',
                'weight',
                'long_diameter',
                'short_diameter',
                'height_long',
                'height_short',
                'body',
                'approval_date',
            );
    }

    /**
     * Map ข้อมูลแต่ละแถว
     */
    public function map($shape): array
    {
        return [
            $shape->item_code, 
            $shape->item_description_thai,
            $shape->item_description_eng,
            $shape->shapeType ? $shape->shapeType->name : '', 
            $shape->status ? $shape->status->status : '', 
            $shape->shapeCollection ? $shape->shapeCollection->collection_code : '', 
            $shape->customer ? $shape->customer->name : '', 
            $shape->itemGroup ? $shape->itemGroup->item_group_name : '', 
            $shape->process ? $shape->process->process_name : '', 
            $shape->designer ? $shape->designer->designer_name : '', 
            $shape->requestor ? $shape->requestor->name : '', 
            $shape->volume,
            $shape->weight,
            $shape->long_diameter,
            $shape->short_diameter,
            $shape->height_long,
            $shape->height_short,
            $shape->body,
            $shape->approval_date ? $shape->approval_date->format('Y-m-d') : '',
        ];
    }

    /**
     * @return array
     */
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
