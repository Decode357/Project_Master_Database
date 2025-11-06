<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class CustomersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    /**
     * @param array $row  // keys come from header row (lowercased)
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // ปรับให้ตรงกับ header ของไฟล์ Excel: code, name, email, phone
        return Customer::updateOrCreate(
            ['code' => $row['code']],
            [
                'name'  => $row['name'] ?? null,
                'email' => $row['email'] ?? null,
                'phone' => $row['phone'] ?? null,
            ]
        );
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'code.required' => 'รหัสลูกค้าจำเป็นต้องระบุ',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
        ];
    }
}
