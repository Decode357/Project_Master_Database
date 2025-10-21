<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get user permissions
     *
     * @return array
     */
    protected function getUserPermissions()
    {
        $user = Auth::user();
        
        if (!$user) {
            return [
                'hasCreate' => false,
                'hasEdit' => false,
                'hasDelete' => false,
                'hasManageUser' => false,
                'hasFileImport' => false,
            ];
        }

        return [$user,
            'hasCreate' => $user->getDirectPermissions()->pluck('name')->contains('create'),
            'hasEdit' => $user->getDirectPermissions()->pluck('name')->contains('edit'),
            'hasDelete' => $user->getDirectPermissions()->pluck('name')->contains('delete'),
            'hasManageUser' => $user->getDirectPermissions()->pluck('name')->contains('manage users'),
            'hasFileImport' => $user->getDirectPermissions()->pluck('name')->contains('file import'),
        ];
    }
}
