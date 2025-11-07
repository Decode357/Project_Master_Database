<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class CustomersImport implements ToCollection, WithHeadingRow, SkipsOnFailure, SkipsEmptyRows
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
            
            // Validate แต่ละแถว
            $validator = Validator::make($row->toArray(), $this->rules(), $this->customValidationMessages());
            
            if ($validator->fails()) {
                // เก็บ failures
                foreach ($validator->errors()->messages() as $attribute => $errors) {
                    $this->failures[] = new Failure(
                        $rowNumber,
                        $attribute,
                        $errors,
                        $row->toArray()
                    );
                }
            } else {
                // เก็บข้อมูลที่ผ่านการ validate
                $this->rowsData[] = $row->toArray();
            }
        }

        // ถ้าไม่มี failures เลย ค่อยบันทึกข้อมูลทั้งหมด
        if (empty($this->failures)) {
            foreach ($this->rowsData as $row) {
                Customer::updateOrCreate(
                    ['code' => $row['code']],
                    [
                        'name'  => $row['name'] ?? null,
                        'email' => $row['email'] ?? null,
                        'phone' => $row['phone'] ?? null,
                    ]
                );
            }
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'code.required' => __('valid.custom.code.required'),
            'code.max' => __('valid.custom.code.max'),
            'name.max' => __('valid.custom.name.max'),
            'email.email' => __('valid.custom.email.email'),
            'email.max' => __('valid.custom.email.max'),
            'phone.max' => __('valid.custom.phone.max'),
        ];
    }

    /**
     * เก็บ failures ที่เกิดขึ้น (ไม่ได้ใช้แล้ว แต่เก็บไว้เผื่อ SkipsOnFailure ต้องการ)
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
