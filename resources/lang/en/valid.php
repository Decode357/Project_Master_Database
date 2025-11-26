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
    'unknown_columns' => '<strong><u>Unknown columns</strong><br><strong>Found:</u></strong> :extra. <br><strong><u>Please use only:</u></strong> :required',
    'invalid_header' => '<strong><u>Invalid Header!</strong> <br><strong>Required:</u></strong> :required. <br><strong><u>Missing:</u></strong> :missing',
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
    'err' => [
        // Backstamp
        'backstamp_code' => [
            'required' => 'Backstamp Code is required.',
            'max' => 'Backstamp Code must not exceed 255 characters.',
        ],
        
        // Pattern
        'pattern_code' => [
            'required' => 'Pattern Code is required.',
            'max' => 'Pattern Code must not exceed 255 characters.',
        ],
        'pattern_name' => [
            'max' => 'Pattern Name must not exceed 255 characters.',
        ],
        
        // Glaze
        'glaze_code' => [
            'required' => 'Glaze Code is required.',
            'max' => 'Glaze Code must not exceed 255 characters.',
        ],
        'inside_code' => [
            'max' => 'Inside Code must not exceed 255 characters.',
        ],
        'outside_code' => [
            'max' => 'Outside Code must not exceed 255 characters.',
        ],
        'fire_temp' => [
            'max' => 'Fire Temperature must not exceed 255 characters.',
        ],
        
        // Shape
        'item_code' => [
            'required' => 'Item Code is required.',
            'max' => 'Item Code must not exceed 255 characters.',
        ],
        'description_thai' => [
            'max' => 'Description Thai must not exceed 255 characters.',
        ],
        'description_eng' => [
            'max' => 'Description English must not exceed 255 characters.',
        ],
        'type' => [
            'max' => 'Type must not exceed 255 characters.',
        ],
        'collection_code' => [
            'max' => 'Collection Code must not exceed 255 characters.',
        ],
        'customer_name' => [
            'max' => 'Customer Name must not exceed 255 characters.',
        ],
        'item_group' => [
            'max' => 'Item Group must not exceed 255 characters.',
        ],
        'process' => [
            'max' => 'Process must not exceed 255 characters.',
        ],
        
        // Numeric fields
        'volume' => [
            'numeric' => 'Volume must be a number.',
        ],
        'weight' => [
            'numeric' => 'Weight must be a number.',
        ],
        'long_diameter' => [
            'numeric' => 'Long Diameter must be a number.',
        ],
        'short_diameter' => [
            'numeric' => 'Short Diameter must be a number.',
        ],
        'height_long' => [
            'numeric' => 'Height Long must be a number.',
        ],
        'height_short' => [
            'numeric' => 'Height Short must be a number.',
        ],
        'body' => [
            'numeric' => 'Body must be a number.',
        ],
        
        // Common fields
        'name' => [
            'max' => 'Name must not exceed 255 characters.',
        ],
        
        // Relations
        'item_group' => [
            'max' => 'Item Group must not exceed 255 characters.',
            'not_found' => 'Item Group ":name" not found in the system.',
        ],
        'glaze_inside' => [
            'max' => 'Glaze Inside must not exceed 255 characters.',
            'not_found' => 'Glaze Inside code ":name" not found in the system.',
        ],
        'glaze_outside' => [
            'max' => 'Glaze Outside must not exceed 255 characters.',
            'not_found' => 'Glaze Outside code ":name" not found in the system.',
        ],
        'effect_code' => [
            'max' => 'Effect Code must not exceed 255 characters.',
            'not_found' => 'Effect code ":name" not found in the system.',
        ],
        'requestor' => [
            'max' => 'Requestor must not exceed 255 characters.',
            'not_found' => 'Requestor named ":name" not found in the system.',
        ],
        'customer' => [
            'max' => 'Customer must not exceed 255 characters.',
            'not_found' => 'Customer named ":name" not found in the system.',
        ],
        'designer' => [
            'max' => 'Designer must not exceed 255 characters.',
            'not_found' => 'Designer named ":name" not found in the system.',
        ],
        'status' => [
            'max' => 'Status must not exceed 255 characters.',
            'not_found' => 'Status ":name" not found in the system.',
        ],
        'shape_type' => [
            'max' => 'Shape Type must not exceed 255 characters.',
            'not_found' => 'Shape Type ":name" not found in the system.',
        ],
        'shape_collection' => [
            'max' => 'Shape Collection must not exceed 255 characters.',
            'not_found' => 'Shape Collection ":name" not found in the system.',
        ],
        
        // Boolean fields
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
        'exclusive' => [
            'in' => 'Exclusive value must be TRUE, FALSE, 1, 0, Yes, No, ใช่, or ไม่ only.',
        ],
        
        // Date
        'approval_date' => [
            'date' => 'Invalid date format.',
        ],
    ],
];
