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
        'approval_date' => [
            'date' => 'Invalid date format.',
        ],
    ],
];
