<?php

namespace App\Imports;

use App\Models\Pattern;
use App\Services\ImportHelperService;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class PatternsImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
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

            // เช็ค status (case-insensitive)
            if (!empty($row['status'])) {
                $statusId = $this->importHelper->findStatusCaseInsensitive($row['status']);
                if ($statusId === null) {
                    $relationErrors[] = __('valid.err.status.not_found', ['name' => $row['status']]);
                } else {
                    $row['status_id'] = $statusId;
                }
            }

            // ถ้ามี relation errors ให้เก็บไว้
            if (!empty($relationErrors)) {
                $this->failures[] = new Failure(
                    $rowNumber,
                    '',
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
                        '',
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
                'pattern_code' => $row['pattern_code'],
                'pattern_name' => $row['pattern_name'] ?? null,
                'status_id' => $row['status_id'] ?? null,
                'customer_id' => $row['customer_id'] ?? null,
                'requestor_id' => $row['requestor_id'] ?? null,
                'designer_id' => $row['designer_id'] ?? null,
                'in_glaze' => $this->importHelper->convertToBoolean($row['in_glaze'] ?? null),
                'on_glaze' => $this->importHelper->convertToBoolean($row['on_glaze'] ?? null),
                'under_glaze' => $this->importHelper->convertToBoolean($row['under_glaze'] ?? null),
                'exclusive' => $this->importHelper->convertToBoolean($row['exclusive'] ?? null),
                'approval_date' => $row['approval_date'] ?? null,
                'updated_by' => auth()->id() ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // แบ่งเป็น chunks ละ 500 แถว เพื่อป้องกัน query ใหญ่เกินไป
        foreach (array_chunk($data, 500) as $chunk) {
            Pattern::upsert(
                $chunk,
                ['pattern_code'],
                [
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
            'pattern_code' => 'required|max:255',
            'pattern_name' => 'nullable|max:255',
            'status' => 'nullable|max:255',
            'customer' => 'nullable|max:255',
            'requestor' => 'nullable|max:255',
            'designer' => 'nullable|max:255',
            'in_glaze' => 'nullable|in:TRUE,FALSE,true,false,1,0,yes,no,Yes,No,YES,NO,ใช่,ไม่',
            'on_glaze' => 'nullable|in:TRUE,FALSE,true,false,1,0,yes,no,Yes,No,YES,NO,ใช่,ไม่',
            'under_glaze' => 'nullable|in:TRUE,FALSE,true,false,1,0,yes,no,Yes,No,YES,NO,ใช่,ไม่',
            'exclusive' => 'nullable|in:TRUE,FALSE,true,false,1,0,yes,no,Yes,No,YES,NO,ใช่,ไม่',
            'approval_date' => 'nullable|date_format:Y-m-d',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'pattern_code.required' => __('valid.err.pattern_code.required'),
            'pattern_code.max' => __('valid.err.pattern_code.max'),
            'pattern_name.max' => __('valid.err.pattern_name.max'),
            'status.max' => __('valid.err.status.max'),
            'customer.max' => __('valid.err.customer.max'),
            'requestor.max' => __('valid.err.requestor.max'),
            'designer.max' => __('valid.err.designer.max'),
            'in_glaze.in' => __('valid.err.in_glaze.in'),
            'on_glaze.in' => __('valid.err.on_glaze.in'),
            'under_glaze.in' => __('valid.err.under_glaze.in'),
            'exclusive.in' => __('valid.err.exclusive.in'),
            'approval_date.date_format' => __('valid.err.approval_date.date'),
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
