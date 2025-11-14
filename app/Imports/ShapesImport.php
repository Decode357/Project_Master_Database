<?php

namespace App\Imports;

use App\Models\Shape;
use App\Services\ImportHelperService;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class ShapesImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    private $failures = [];
    private $rowsData = [];
    private $importHelper;

    public function __construct()
    {
        $this->importHelper = new ImportHelperService();
    }

    /**
     * เก็บข้อมูลทั้งหมดไว้ก่อน ไม่บันทึกทันที
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;
            $hasErrors = false;

            // แปลง approval_date จาก Excel format ก่อน validate
            if (!empty($row['approval_date'])) {
                $row['approval_date'] = $this->parseExcelDate($row['approval_date']);
            }

            // 1. เช็ค relations แบบ fast lookup
            $relationErrors = [];

            // เช็ค type (case-insensitive)
            if (!empty($row['type'])) {
                $shapeTypeId = $this->importHelper->findShapeTypeCaseInsensitive($row['type']);
                if ($shapeTypeId === null) {
                    $relationErrors[] = __('valid.err.shape_type.not_found', ['name' => $row['type']]);
                } else {
                    $row['shape_type_id'] = $shapeTypeId;
                }
            }

            // เช็ค status (case-insensitive)
            if (!empty($row['status'])) {
                $statusId = $this->importHelper->findStatusCaseInsensitive($row['status']);
                if ($statusId === null) {
                    $relationErrors[] = __('valid.err.status.not_found', ['name' => $row['status']]);
                } else {
                    $row['status_id'] = $statusId;
                }
            }

            // เช็ค shape_collection (case-insensitive)
            if (!empty($row['collection_code'])) {
                $collectionCodeId = $this->importHelper->findShapeCollectionCaseInsensitive($row['collection_code']);
                if ($collectionCodeId === null) {
                    $relationErrors[] = __('valid.err.shape_collection.not_found', ['name' => $row['collection_code']]);
                } else {
                    $row['shape_collection_id'] = $collectionCodeId;
                }
            }

            // เช็ค item_group - ถ้าไม่เจอให้สร้างใหม่
            if (!empty($row['item_group'])) {
                $itemGroupId = $this->importHelper->getOrCreateItemGroup($row['item_group']);
                $row['item_group_id'] = $itemGroupId;
            }
            // เช็ค requestor - ถ้าไม่เจอให้สร้างใหม่
            if (!empty($row['process'])) {
                $processId = $this->importHelper->getOrCreateProcess($row['process']);
                $row['process_id'] = $processId;
            }

            // เช็ค requestor - ถ้าไม่เจอให้สร้างใหม่
            if (!empty($row['requestor'])) {
                $requestorId = $this->importHelper->getOrCreateRequestor($row['requestor']);
                $row['requestor_id'] = $requestorId;
            }

            // เช็ค designer - ถ้าไม่เจอให้สร้างใหม่
            if (!empty($row['designer'])) {
                $designerId = $this->importHelper->getOrCreateDesigner($row['designer']);
                $row['designer_id'] = $designerId;
            }

            // เช็ค customer (case-insensitive)
            if (!empty($row['customer'])) {
                $customerId = $this->importHelper->findCustomerCaseInsensitive($row['customer']);
                if ($customerId === null) {
                    $relationErrors[] = __('valid.err.customer.not_found', ['name' => $row['customer']]);
                } else {
                    $row['customer_id'] = $customerId;
                }
            }

            // ถ้ามี relation errors ให้เก็บไว้
            if (!empty($relationErrors)) {
                $this->failures[] = new Failure(
                    $rowNumber,
                    'relations',
                    $relationErrors,
                    $row->toArray()
                );
                $hasErrors = true;
            }

            // 2. เช็ค validation ทั่วไป
            $validator = Validator::make($row->toArray(), $this->rules(), $this->customValidationMessages());
            
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $attribute => $errors) {
                    $this->failures[] = new Failure(
                        $rowNumber,
                        $attribute,
                        $errors,
                        $row->toArray()
                    );
                }
                $hasErrors = true;
            }

            // 3. ถ้าไม่มี error เก็บข้อมูลไว้
            if (!$hasErrors) {
                $this->rowsData[] = $row->toArray();
            }
        }

        // ถ้าไม่มี failures เลย ค่อยบันทึกข้อมูลทั้งหมด
        if (empty($this->failures)) {
            $this->batchUpsert();
        }
    }

    /**
     * Batch Upsert - บันทึกข้อมูลทั้งหมดพร้อมกัน
     */
    private function batchUpsert()
    {
        $data = [];
        $now = now();
        
        foreach ($this->rowsData as $row) {
            $data[] = [
                'item_code' => $row['item_code'],
                'item_description_thai' => $row['description_thai'],
                'item_description_eng' => $row['description_eng'],
                'shape_type_id' => $row['shape_type_id'] ?? null,
                'status_id' => $row['status_id'] ?? null,
                'shape_collection_id' => $row['shape_collection_id'] ?? null,
                'customer_id' => $row['customer_id'] ?? null,
                'item_group_id' => $row['item_group_id'] ?? null,
                'process_id' => $row['process_id'] ?? null,
                'designer_id' => $row['designer_id'] ?? null,
                'requestor_id' => $row['requestor_id'] ?? null,
                'updated_by' => auth()->id() ?? null,
                'volume' => $row['volume'] ?? null,
                'weight' => $row['weight'] ?? null,
                'long_diameter' => $row['long_diameter'] ?? null,
                'short_diameter' => $row['short_diameter'] ?? null,
                'height_long' => $row['height_long'] ?? null,
                'height_short' => $row['height_short'] ?? null,
                'body' => $row['body'] ?? null,
                'approval_date' => $row['approval_date'] ?? null,
                'updated_by' => auth()->id() ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // แบ่งเป็น chunks ละ 500 แถว เพื่อป้องกัน query ใหญ่เกินไป
        foreach (array_chunk($data, 500) as $chunk) {
            Shape::upsert(
                $chunk,
                ['item_code'],
                [
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
                    'updated_by',
                    'updated_at'
                ]
            );
        }
    }

    /**
     * ดึง failures ทั้งหมด
     */
    public function getFailures()
    {
        return $this->failures;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'item_code' => 'required|max:255',
            'description_thai' => 'nullable|max:255',
            'description_eng' => 'nullable|max:255',
            'type' => 'nullable|max:255',
            'status' => 'nullable|max:255',
            'collection_code' => 'nullable|max:255',
            'customer_name' => 'nullable|max:255',
            'item_group' => 'nullable|max:255',
            'process' => 'nullable|max:255',
            'designer' => 'nullable|max:255',
            'requestor' => 'nullable|max:255',
            'volume' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'long_diameter' => 'nullable|numeric',
            'short_diameter' => 'nullable|numeric',
            'height_long' => 'nullable|numeric',
            'height_short' => 'nullable|numeric',
            'body' => 'nullable|numeric',
            'approval_date' => 'nullable|date_format:Y-m-d',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'item_code.required' => __('valid.err.item_code.required'),
            'item_code.max' => __('valid.err.item_code.max'),
            'description_thai.max' => __('valid.err.name.max'),
            'description_eng.max' => __('valid.err.name.max'),
            'type.max' => __('valid.err.shape_type.max'),
            'status.max' => __('valid.err.status.max'),
            'collection_code.max' => __('valid.err.shape_collection.max'),
            'customer_name.max' => __('valid.err.customer.max'),
            'item_group.max' => __('valid.err.item_group.max'),
            'process.max' => __('valid.err.process.max'),
            'designer.max' => __('valid.err.designer.max'),
            'requestor.max' => __('valid.err.requestor.max'),
            'volume.numeric' => __('valid.err.volume.numeric'),
            'weight.numeric' => __('valid.err.weight.numeric'),
            'long_diameter.numeric' => __('valid.err.long_diameter.numeric'),
            'short_diameter.numeric' => __('valid.err.short_diameter.numeric'),
            'height_long.numeric' => __('valid.err.height_long.numeric'),
            'height_short.numeric' => __('valid.err.height_short.numeric'),
            'body.numeric' => __('valid.err.body.numeric'),
            'approval_date.date_format' => __('valid.err.approval_date.date')
        ];
    }

    /**
     * แปลงวันที่จาก Excel ให้เป็น Y-m-d format
     */
    private function parseExcelDate($date)
    {
        if (empty($date) || is_null($date)) {
            return null;
        }

        try {
            if (is_numeric($date)) {
                $unixDate = ExcelDate::excelToTimestamp($date);
                return Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
            }

            if ($date instanceof \DateTime) {
                return $date->format('Y-m-d');
            }

            if (is_string($date)) {
                $date = trim($date);
                
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                    return $date;
                }
                
                return Carbon::parse($date)->format('Y-m-d');
            }

            return null;
        } catch (\Exception $e) {
            return $date;
        }
    }
}
