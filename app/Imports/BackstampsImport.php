<?php
// filepath: c:\laragon\www\MasterDataDemo\app\Imports\BackstampsImport.php

namespace App\Imports;

use App\Models\Backstamp;
use App\Models\Requestor;
use App\Models\Customer;
use App\Models\Status;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class BackstampsImport implements ToCollection, WithHeadingRow, SkipsOnFailure, SkipsEmptyRows
{
    private $failures = [];
    private $rowsData = [];
    
    // Cache collections สำหรับเร่งความเร็ว
    private $requestors;
    private $customers;
    private $statuses;

    public function __construct()
    {
        // โหลดข้อมูล relations ทั้งหมดครั้งเดียว
        $this->requestors = Requestor::pluck('id', 'name')->toArray();
        $this->customers = Customer::pluck('id', 'name')->toArray();
        $this->statuses = Status::pluck('id', 'status')->toArray();
    }

    /**
     * เก็บข้อมูลทั้งหมดไว้ก่อน ไม่บันทึกทันที
     */
    public function collection(Collection $rows)
    {
        // วนลูปเช็ค validation ทุกแถวก่อน
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;
            $hasErrors = false;

            // แปลง approval_date จาก Excel format ก่อน validate
            if (!empty($row['approval_date'])) {
                $row['approval_date'] = $this->parseExcelDate($row['approval_date']);
            }

            // 1. เช็ค relations แบบ fast lookup
            $relationErrors = [];

            // เช็ค requestor
            if (!empty($row['requestor']) && !isset($this->requestors[$row['requestor']])) {
                $relationErrors[] = __('valid.backst.requestor.not_found', ['name' => $row['requestor']]);
            }

            // เช็ค customer
            if (!empty($row['customer']) && !isset($this->customers[$row['customer']])) {
                $relationErrors[] = __('valid.backst.customer.not_found', ['name' => $row['customer']]);
            }

            // เช็ค status
            if (!empty($row['status']) && !isset($this->statuses[$row['status']])) {
                $relationErrors[] = __('valid.backst.status.not_found', ['name' => $row['status']]);
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
                'backstamp_code' => $row['backstamp_code'],
                'name' => $row['name'] ?? null,
                'requestor_id' => $this->requestors[$row['requestor']] ?? null,
                'customer_id' => $this->customers[$row['customer']] ?? null,
                'status_id' => $this->statuses[$row['status']] ?? null,
                'organic' => $this->convertToBoolean($row['organic'] ?? null),
                'in_glaze' => $this->convertToBoolean($row['in_glaze'] ?? null),
                'on_glaze' => $this->convertToBoolean($row['on_glaze'] ?? null),
                'under_glaze' => $this->convertToBoolean($row['under_glaze'] ?? null),
                'air_dry' => $this->convertToBoolean($row['air_dry'] ?? null),
                'approval_date' => $row['approval_date'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // แบ่งเป็น chunks ละ 500 แถว เพื่อป้องกัน query ใหญ่เกินไป
        foreach (array_chunk($data, 500) as $chunk) {
            Backstamp::upsert(
                $chunk,                                    // ข้อมูลทั้งหมด
                ['backstamp_code'],                        // Unique key สำหรับเช็คซ้ำ
                [                                          // ฟิลด์ที่จะ update ถ้าเจอข้อมูลเก่า
                    'name',
                    'requestor_id',
                    'customer_id',
                    'status_id',
                    'organic',
                    'in_glaze',
                    'on_glaze',
                    'under_glaze',
                    'air_dry',
                    'approval_date',
                    'updated_at'
                ]
            );
        }
    }

    /**
     * แปลงค่าเป็น Boolean (0 หรือ 1)
     */
    private function convertToBoolean($value)
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        if (is_numeric($value)) {
            return (int)$value > 0 ? 1 : 0;
        }

        $value = strtolower(trim($value));
        
        if (in_array($value, ['true', 'yes', '1', 'ใช่'])) {
            return 1;
        }

        return 0;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'backstamp_code' => 'required|max:255',
            'name' => 'nullable|max:255',
            'requestor' => 'nullable|max:255',
            'customer' => 'nullable|max:255',
            'status' => 'nullable|max:255',
            'organic' => 'nullable|in:TRUE,FALSE,true,false,1,0,yes,no,Yes,No,YES,NO,ใช่,ไม่',
            'in_glaze' => 'nullable|in:TRUE,FALSE,true,false,1,0,yes,no,Yes,No,YES,NO,ใช่,ไม่',
            'on_glaze' => 'nullable|in:TRUE,FALSE,true,false,1,0,yes,no,Yes,No,YES,NO,ใช่,ไม่',
            'under_glaze' => 'nullable|in:TRUE,FALSE,true,false,1,0,yes,no,Yes,No,YES,NO,ใช่,ไม่',
            'air_dry' => 'nullable|in:TRUE,FALSE,true,false,1,0,yes,no,Yes,No,YES,NO,ใช่,ไม่',
            'approval_date' => 'nullable|date_format:Y-m-d',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'backstamp_code.required' => __('valid.backst.backstamp_code.required'),
            'backstamp_code.max' => __('valid.backst.backstamp_code.max'),
            'name.max' => __('valid.backst.name.max'),
            'requestor.max' => __('valid.backst.requestor.max'),
            'customer.max' => __('valid.backst.customer.max'),
            'status.max' => __('valid.backst.status.max'),
            'organic.in' => __('valid.backst.organic.in'),
            'in_glaze.in' => __('valid.backst.in_glaze.in'),
            'on_glaze.in' => __('valid.backst.on_glaze.in'),
            'under_glaze.in' => __('valid.backst.under_glaze.in'),
            'air_dry.in' => __('valid.backst.air_dry.in'),
            'approval_date.date_format' => __('valid.backst.approval_date.date'),
        ];
    }

    /**
     * เก็บ failures ที่เกิดขึ้น
     */
    public function onFailure(Failure ...$failures)
    {
        // ไม่ต้องทำอะไร เพราะเราจัดการเองใน collection()
    }

    /**
     * ดึง failures ทั้งหมด
     */
    public function getFailures()
    {
        return $this->failures;
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
