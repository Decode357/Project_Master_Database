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
    'unknown_columns' => '<strong><u>คอลัมน์ที่ไม่รู้จัก</strong><br><strong>พบ:</u></strong> :extra. <br><strong><u>โปรดใช้เฉพาะ:</u></strong> :required',
    'invalid_header' => '<strong><u>Header ไม่ถูกต้อง!</strong> <br><strong>ต้องมี:</u></strong> :required. <br><u><strong>หาไม่เจอ:</u></strong> :missing',
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
    'err' => [
        // Backstamp
        'backstamp_code' => [
            'required' => 'Backstamp Code จำเป็นต้องระบุ',
            'max' => 'Backstamp Code ต้องไม่เกิน 255 ตัวอักษร',
        ],
        
        // Pattern
        'pattern_code' => [
            'required' => 'Pattern Code จำเป็นต้องระบุ',
            'max' => 'Pattern Code ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'pattern_name' => [
            'max' => 'Pattern Name ต้องไม่เกิน 255 ตัวอักษร',
        ],
        
        // Glaze
        'glaze_code' => [
            'required' => 'Glaze Code จำเป็นต้องระบุ',
            'max' => 'Glaze Code ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'inside_code' => [
            'max' => 'Inside Code ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'outside_code' => [
            'max' => 'Outside Code ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'fire_temp' => [
            'max' => 'Fire Temperature ต้องไม่เกิน 255 ตัวอักษร',
        ],
        
        // Shape
        'item_code' => [
            'required' => 'Item Code จำเป็นต้องระบุ',
            'max' => 'Item Code ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'description_thai' => [
            'max' => 'Description Thai ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'description_eng' => [
            'max' => 'Description English ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'type' => [
            'max' => 'Type ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'collection_code' => [
            'max' => 'Collection Code ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'customer_name' => [
            'max' => 'Customer Name ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'item_group' => [
            'max' => 'Item Group ต้องไม่เกิน 255 ตัวอักษร',
        ],
        'process' => [
            'max' => 'Process ต้องไม่เกิน 255 ตัวอักษร',
        ],
        
        // Numeric fields
        'volume' => [
            'numeric' => 'Volume ต้องเป็นตัวเลข',
        ],
        'weight' => [
            'numeric' => 'Weight ต้องเป็นตัวเลข',
        ],
        'long_diameter' => [
            'numeric' => 'Long Diameter ต้องเป็นตัวเลข',
        ],
        'short_diameter' => [
            'numeric' => 'Short Diameter ต้องเป็นตัวเลข',
        ],
        'height_long' => [
            'numeric' => 'Height Long ต้องเป็นตัวเลข',
        ],
        'height_short' => [
            'numeric' => 'Height Short ต้องเป็นตัวเลข',
        ],
        'body' => [
            'numeric' => 'Body ต้องเป็นตัวเลข',
        ],
        
        // Common fields
        'name' => [
            'max' => 'Name ต้องไม่เกิน 255 ตัวอักษร',
        ],
        
        // Relations
        'glaze_inside' => [
            'max' => 'Glaze Inside ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Glaze Inside รหัส ":name" ในระบบ',
        ],
        'glaze_outside' => [
            'max' => 'Glaze Outside ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Glaze Outside รหัส ":name" ในระบบ',
        ],
        'effect_code' => [
            'max' => 'Effect Code ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Effect รหัส ":name" ในระบบ',
        ],
        'requestor' => [
            'max' => 'Requestor ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Requestor ชื่อ ":name" ในระบบ',
        ],
        'customer' => [
            'max' => 'Customer ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Customer ชื่อ ":name" ในระบบ',
        ],
        'designer' => [
            'max' => 'Designer ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Designer ชื่อ ":name" ในระบบ',
        ],
        'status' => [
            'max' => 'Status ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Status ":name" ในระบบ',
        ],
        'shape_type' => [
            'max' => 'Shape Type ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Shape Type ":name" ในระบบ',
        ],
        'shape_collection' => [
            'max' => 'Shape Collection ต้องไม่เกิน 255 ตัวอักษร',
            'not_found' => 'ไม่พบ Shape Collection ":name" ในระบบ',
        ],
        
        // Boolean fields
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
        'exclusive' => [
            'in' => 'ค่า Exclusive ต้องเป็น TRUE, FALSE, 1, 0, Yes, No, ใช่, หรือ ไม่ เท่านั้น',
        ],
        
        // Date
        'approval_date' => [
            'date' => 'รูปแบบวันที่ไม่ถูกต้อง',
        ],
    ],
];
