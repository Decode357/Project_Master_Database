<?php
return [
    '' => '',
    'file_required' => 'Please select a file to upload',
    'file_mimes' => 'The file must be of type: xlsx, xls, csv only',
    'file_max' => 'The file size must not exceed :max',
    'critical_error' => 'A critical error occurred: ',
    'import_success' => 'Data imported successfully!',
    'found_error_count' => 'Found :count errors (please correct all before importing)',
    'and_more' => '. . . and :count more',
    'row' => 'Row',
    'unknown_columns' => '<strong>Unknown columns</strong><br><strong>Found:</strong> :extra. <br><strong>Please use only:</strong> :required',
    'invalid_header' => '<strong>Invalid Header!</strong> <br><strong>Required:</strong> :required. <br><strong>Missing:</strong> :missing',
    'custom' => [
        'code' => [
            'required' => 'Code is required.',
            'max' => 'Code must not exceed 255 characters.',
        ],
        'name' => [
            'max' => 'Name must not exceed 255 characters.',
        ],
        'email' => [
            'email' => 'Invalid Email format.',
            'max' => 'Email must not exceed 255 characters.',
        ],
        'phone' => [
            'max' => 'Phone must not exceed 20 characters.',
        ],
    ],
    'backst' => [
        'backstamp_code' => [
            'required' => 'Backstamp Code is required.',
            'max' => 'Backstamp Code must not exceed 255 characters.',
        ],
        'name' => [
            'max' => 'Name must not exceed 255 characters.',
        ],
        'requestor' => [
            'max' => 'Requestor must not exceed 255 characters.',
            'not_found' => 'Requestor named ":name" not found in the system.',
        ],
        'customer' => [
            'max' => 'Customer must not exceed 255 characters.',
            'not_found' => 'Customer named ":name" not found in the system.',
        ],
        'status' => [
            'max' => 'Status must not exceed 255 characters.',
            'not_found' => 'Status named ":name" not found in the system.',
        ],
        'organic' => [
            'in' => 'Organic value must be TRUE, FALSE, 1, 0, Yes, No, ใช่, or ไม่ only.',
        ],
        'in_glaze' => [
            'in' => 'In Glaze value must be TRUE, FALSE, 1, 0, Yes, No, ใช่, or ไม่ only.',
        ],
        'on_glaze' => [
            'in' => 'On Glaze value must be TRUE, FALSE, 1, 0, Yes, No, ใช่, or ไม่ only.',
        ],
        'under_glaze' => [
            'in' => 'Under Glaze value must be TRUE, FALSE, 1, 0, Yes, No, ใช่, or ไม่ only.',
        ],
        'air_dry' => [
            'in' => 'Air Dry value must be TRUE, FALSE, 1, 0, Yes, No, ใช่, or ไม่ only.',
        ],
        'approval_date' => [
            'date' => 'Invalid date format.',
        ],
    ],
];
