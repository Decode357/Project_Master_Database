<?php
return [
    '' => '',
    'file_required' => 'โปรดเลือกไฟล์ที่จะอัปโหลด',
    'file_mimes' => 'ไฟล์ต้องเป็นรูปแบบ: xlsx, xls, csv เท่านั้น',
    'file_max' => 'ขนาดไฟล์ต้องไม่เกิน :max',
    'critical_error' => 'เกิดข้อผิดพลาดร้ายแรง: ',
    'import_success' => 'นำเข้าข้อมูลสำเร็จ!',
    'found_error_count' => 'พบข้อผิดพลาด :count รายการ (ต้องแก้ไขให้ถูกต้องทั้งหมดก่อนนำเข้า)',
    'and_more' => '. . . และอีก :count รายการ',
    'row' => 'แถว',
    'unknown_columns' => 'พบคอลัมน์ที่ไม่รู้จัก: :extra. กรุณาใช้เฉพาะ: :required',
    'invalid_header' => 'Header ไม่ถูกต้อง! ต้องมี: :required. หาไม่เจอ: :missing',
    'custom' => [
        'code' => [
            'required' => 'Code จำเป็นต้องระบุ',
            'max' => 'Code ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'name' => [
            'max' => 'Name ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'email' => [
            'email' => 'รูปแบบ Email ไม่ถูกต้อง',
            'max' => 'Email ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'phone' => [
            'max' => 'Phone ต้องไม่เกิน 20 ตัวอักษร',
        ],
    ],
    'backst' => [
        'backstamp_code' => [
            'required' => 'Backstamp Code จำเป็นต้องระบุ',
            'max' => 'Backstamp Code ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'name' => [
            'max' => 'Name ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'requestor' => [
            'max' => 'Requestor ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Requestor ชื่อ ":name" ในระบบ',
        ],
        'customer' => [
            'max' => 'Customer ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Customer ชื่อ ":name" ในระบบ',
        ],
        'status' => [
            'max' => 'Status ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Status ":name" ในระบบ',
        ],
        'organic' => [
            'in' => 'ค่า Organic ต้องเป็น TRUE, FALSE, 1, 0, Yes, No, ใช่, หรือ ไม่ เท่านั้น',
        ],
        'in_glaze' => [
            'in' => 'ค่า In Glaze ต้องเป็น TRUE, FALSE, 1, 0, Yes, No, ใช่, หรือ ไม่ เท่านั้น',
        ],
        'on_glaze' => [
            'in' => 'ค่า On Glaze ต้องเป็น TRUE, FALSE, 1, 0, Yes, No, ใช่, หรือ ไม่ เท่านั้น',
        ],
        'under_glaze' => [
            'in' => 'ค่า Under Glaze ต้องเป็น TRUE, FALSE, 1, 0, Yes, No, ใช่, หรือ ไม่ เท่านั้น',
        ],
        'air_dry' => [
            'in' => 'ค่า Air Dry ต้องเป็น TRUE, FALSE, 1, 0, Yes, No, ใช่, หรือ ไม่ เท่านั้น',
        ],
        'approval_date' => [
            'date' => 'รูปแบบวันที่ไม่ถูกต้อง',
        ],
    ],
];
