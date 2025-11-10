<?php

namespace App\Imports;

use App\Models\Backstamp;
use App\Models\Requestor;
use App\Models\Customer;
use App\Models\Status;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class BackstampsImport implements ToCollection, WithHeadingRow, SkipsOnFailure, SkipsEmptyRows
{
    private $failures = [];
    private $rowsData = [];

    /**
     * เก็บข้อมูลทั้งหมดไว้ก่อน ไม่บันทึกทันที
     */
    public function collection(Collection $rows)
    {
        // วนลูปเช็ค validation ทุกแถวก่อน
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 เพราะ index เริ่ม 0 และแถว 1 คือ header
            
            $hasErrors = false;
            
            // 1. เช็ค relations ก่อน (ไม่ว่า validation จะผ่านหรือไม่)
            $relationErrors = [];

            // เช็ค requestor
            if (!empty($row['requestor'])) {
                $requestor = Requestor::where('name', $row['requestor'])->first();
                if (!$requestor) {
                    $relationErrors[] = __('valid.backst.requestor.not_found', ['name' => $row['requestor']]);
                }
            }

            // เช็ค customer
            if (!empty($row['customer'])) {
                $customer = Customer::where('name', $row['customer'])->first();
                if (!$customer) {
                    $relationErrors[] = __('valid.backst.customer.not_found', ['name' => $row['customer']]);
                }
            }

            // เช็ک status
            if (!empty($row['status'])) {
                $status = Status::where('status', $row['status'])->first();
                if (!$status) {
                    $relationErrors[] = __('valid.backst.status.not_found', ['name' => $row['status']]);
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
                // เก็บ validation failures
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
            foreach ($this->rowsData as $row) {
                // หา ID จากชื่อ (เพราะ Excel เป็นชื่อ ไม่ใช่ ID)
                $requestorId = $this->getRequestorId($row['requestor']);
                $customerId = $this->getCustomerId($row['customer']);
                $statusId = $this->getStatusId($row['status']);

                Backstamp::updateOrCreate(
                    ['backstamp_code' => $row['backstamp_code']],
                    [
                        'name' => $row['name'] ?? null,
                        'requestor_id' => $requestorId,
                        'customer_id' => $customerId,
                        'status_id' => $statusId,
                        'organic' => $this->convertToBoolean($row['organic'] ?? null),
                        'in_glaze' => $this->convertToBoolean($row['in_glaze'] ?? null),
                        'on_glaze' => $this->convertToBoolean($row['on_glaze'] ?? null),
                        'under_glaze' => $this->convertToBoolean($row['under_glaze'] ?? null),
                        'air_dry' => $this->convertToBoolean($row['air_dry'] ?? null),
                        'approval_date' => $row['approval_date'] ?? null,
                    ]
                );
            }
        }
    }

    /**
     * แปลงค่าเป็น Boolean (0 หรือ 1)
     */
    private function convertToBoolean($value)
    {
        if ($value === null || $value === '') {
            return 0; // ค่า default เป็น FALSE
        }

        // แปลงค่าต่างๆ เป็น boolean
        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        if (is_numeric($value)) {
            return (int)$value > 0 ? 1 : 0;
        }

        // แปลงจาก string
        $value = strtolower(trim($value));
        
        if (in_array($value, ['true', 'yes', '1', 'ใช่'])) {
            return 1;
        }

        if (in_array($value, ['false', 'no', '0', 'ไม่'])) {
            return 0;
        }

        return 0; // default
    }

    /**
     * หา Requestor ID จากชื่อ
     */
    private function getRequestorId($name)
    {
        if (empty($name)) {
            return null;
        }

        $requestor = Requestor::where('name', $name)->first();
        return $requestor ? $requestor->id : null;
    }

    /**
     * หา Customer ID จากชื่อ
     */
    private function getCustomerId($name)
    {
        if (empty($name)) {
            return null;
        }

        $customer = Customer::where('name', $name)->first();
        return $customer ? $customer->id : null;
    }

    /**
     * หา Status ID จากชื่อ
     */
    private function getStatusId($status)
    {
        if (empty($status)) {
            return null;
        }

        $statusModel = Status::where('status', $status)->first();
        return $statusModel ? $statusModel->id : null;
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
            'approval_date' => 'nullable|date',
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
            'approval_date.date' => __('valid.backst.approval_date.date'),
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
}
