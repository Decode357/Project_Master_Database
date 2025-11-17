<?php

return [
    'shape' => [
        'created' => 'Shape created successfully!',
        'updated' => 'Shape updated successfully!',
        'deleted' => 'Shape deleted successfully',
    ],
    'shape_collection' => [
        'created' => 'Collection created successfully!',
        'updated' => 'Collection updated successfully!',
        'deleted' => 'Collection deleted successfully',
    ],
    'glaze' => [
        'created' => 'Glaze created successfully!',
        'updated' => 'Glaze updated successfully!',
        'deleted' => 'Glaze deleted successfully',
    ],
    'glaze_inside' => [
        'created' => 'Inside glaze created successfully!',
        'updated' => 'Inside glaze updated successfully!',
        'deleted' => 'Inside glaze deleted successfully',
    ],
    'glaze_outer' => [
        'created' => 'Outer glaze created successfully!',
        'updated' => 'Outer glaze updated successfully!',
        'deleted' => 'Outer glaze deleted successfully',
    ],
    'effect' => [
        'created' => 'Effect created successfully!',
        'updated' => 'Effect updated successfully!',
        'deleted' => 'Effect deleted successfully',
    ],
    'color' => [
        'created' => 'Color created successfully!',
        'updated' => 'Color updated successfully!',
        'deleted' => 'Color deleted successfully',
    ],
    'pattern' => [
        'created' => 'Pattern created successfully!',
        'updated' => 'Pattern updated successfully!',
        'deleted' => 'Pattern deleted successfully',
    ],
    'backstamp' => [
        'created' => 'Backstamp created successfully!',
        'updated' => 'Backstamp updated successfully!',
        'deleted' => 'Backstamp deleted successfully',
    ],
    'user' => [
        'created' => 'User created successfully!',
        'updated' => 'User updated successfully!',
        'deleted' => 'User deleted successfully',
    ],
    'profile' => [
        'updated' => 'Profile updated successfully!',
    ],
    'validation' => [
        'item_code' => [
            'required' => 'Item code is required',
            'unique' => 'This item code already exists',
            'max' => 'Item code must not exceed :max characters',
        ],
        'collection_code' => [
            'required' => 'Collection code is required',
            'unique' => 'This collection code already exists',
            'max' => 'Collection code must not exceed :max characters',
        ],
        'collection_name' => [
            'unique' => 'This collection name already exists',
            'max' => 'Collection name must not exceed :max characters',
        ],
        'glaze_code' => [
            'required' => 'Glaze code is required',
            'unique' => 'This glaze code already exists',
            'max' => 'Glaze code must not exceed :max characters',
        ],
        'glaze_inside_code' => [
            'required' => 'Inside glaze code is required',
            'unique' => 'This inside glaze code already exists',
            'max' => 'Inside glaze code must not exceed :max characters',
        ],
        'glaze_outer_code' => [
            'required' => 'Outer glaze code is required',
            'unique' => 'This outer glaze code already exists',
            'max' => 'Outer glaze code must not exceed :max characters',
        ],
        'effect_code' => [
            'required' => 'Effect code is required',
            'unique' => 'This effect code already exists',
            'max' => 'Effect code must not exceed :max characters',
        ],
        'effect_name' => [
            'max' => 'Effect name must not exceed :max characters',
        ],
        'color_code' => [
            'required' => 'Color code is required',
            'max' => 'Color code must not exceed :max characters',
        ],
        'color_name' => [
            'max' => 'Color name must not exceed :max characters',
        ],
        'pattern_code' => [
            'required' => 'Pattern code is required',
            'unique' => 'This pattern code already exists',
            'max' => 'Pattern code must not exceed :max characters',
        ],
        'pattern_name' => [
            'max' => 'Pattern name must not exceed :max characters',
        ],
        'backstamp_code' => [
            'required' => 'Backstamp code is required',
            'unique' => 'This backstamp code already exists',
            'max' => 'Backstamp code must not exceed :max characters',
        ],
        'name' => [
            'required' => 'Name is required',
            'max' => 'Name must not exceed :max characters',
        ],
        'email' => [
            'required' => 'Email is required',
            'email' => 'Invalid email format',
            'unique' => 'This email already exists',
        ],
        'password' => [
            'required' => 'Password is required',
            'min' => 'Password must be at least :min characters',
        ],
        'role' => [
            'required' => 'Role is required',
            'in' => 'Selected role is invalid',
        ],
        'permissions' => [
            'array' => 'Permissions must be an array',
        ],
        'permissions.*' => [
            'string' => 'Permission must be a string',
        ],
        'department_id' => [
            'exists' => 'Selected department is invalid',
        ],
        'air_dry' => [
            'boolean' => 'Air Dry must be true or false',
        ],
        'organic' => [
            'boolean' => 'Organic must be true or false',
        ],
        'in_glaze' => [
            'boolean' => 'In Glaze must be true or false',
        ],
        'on_glaze' => [
            'boolean' => 'On Glaze must be true or false',
        ],
        'under_glaze' => [
            'boolean' => 'Under Glaze must be true or false',
        ],
        'exclusive' => [
            'boolean' => 'Exclusive must be true or false',
        ],
        'requestor_id' => [
            'exists' => 'Selected requestor is invalid',
        ],
        'designer_id' => [
            'exists' => 'Selected designer is invalid',
        ],
        'colors' => [
            'array' => 'Colors must be an array',
        ],
        'colors.*' => [
            'exists' => 'Selected color is invalid',
        ],
        'fire_temp' => [
            'integer' => 'Fire temperature must be an integer',
        ],
        'glaze_inside_id' => [
            'exists' => 'Selected inside glaze is invalid',
        ],
        'glaze_outer_id' => [
            'exists' => 'Selected outer glaze is invalid',
        ],
        'effect_id' => [
            'exists' => 'Selected effect is invalid',
        ],
        'item_description_thai' => [
            'max' => 'Thai description must not exceed :max characters',
        ],
        'item_description_eng' => [
            'max' => 'English description must not exceed :max characters',
        ],
        'shape_type_id' => [
            'exists' => 'Selected shape type is invalid',
        ],
        'status_id' => [
            'exists' => 'Selected status is invalid',
        ],
        'customer_id' => [
            'exists' => 'Selected customer is invalid',
        ],
        'shape_collection_id' => [
            'exists' => 'Selected collection is invalid',
        ],
        'volume' => [
            'numeric' => 'Volume must be a number',
        ],
        'weight' => [
            'numeric' => 'Weight must be a number',
        ],
        'long_diameter' => [
            'numeric' => 'Long diameter must be a number',
        ],
        'short_diameter' => [
            'numeric' => 'Short diameter must be a number',
        ],
        'height_long' => [
            'numeric' => 'Long height must be a number',
        ],
        'height_short' => [
            'numeric' => 'Short height must be a number',
        ],
        'body' => [
            'numeric' => 'Body must be a number',
        ],
        'approval_date' => [
            'date' => 'Invalid approval date',
        ],
    ],
];
