<?php
return [
    '' => '',
    'critical_error' => 'A critical error occurred: ',
    'import_success' => 'Customer data imported successfully!',
    'found_error_count' => 'Found :count errors (please correct all before importing)',
    'and_more' => '. . . and :count more',
    'row' => 'Row',
    'unknown_columns' => 'Unknown columns found: :extra. Please use only: :required',
    'invalid_header' => 'Invalid header! Required: :required. Missing: :missing',
    'custom' => [
        'code' => [
            'required' => 'Customer code is required.',
            'max' => 'Customer code must not exceed 255 characters.',
        ],
        'name' => [
            'max' => 'Customer name must not exceed 255 characters.',
        ],
        'email' => [
            'email' => 'Invalid email format.',
            'max' => 'Email must not exceed 255 characters.',
        ],
        'phone' => [
            'max' => 'Phone number must not exceed 20 characters.',
        ],
    ],
];
