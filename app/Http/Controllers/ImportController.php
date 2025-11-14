<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CustomersImport;
use App\Imports\BackstampsImport;
use App\Imports\PatternsImport;
use App\Imports\ShapesImport;
use App\Imports\GlazesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\HeadingRowImport;

class ImportController extends Controller
{
    /**
     * Import Customers
     */
    public function customer_import(Request $request)
    {
        $requiredHeaders = ['code', 'name', 'email', 'phone'];
        $importClass = CustomersImport::class;
        
        return $this->processImport($request, $requiredHeaders, $importClass, 'customers', 'customer_import');
    }

    /**
     * Import Shapes
     */
    public function shape_import(Request $request)
    {
        $requiredHeaders = [
            'item_code',
            'description_thai',
            'description_eng',
            'type',
            'status',
            'collection_code',
            'customer',
            'item_group',
            'process',
            'designer',
            'requestor',
            'volume',
            'weight',
            'long_diameter',
            'short_diameter',
            'height_long',
            'height_short',
            'body',
            'approval_date',
        ];
        $importClass = ShapesImport::class;
        return $this->processImport($request, $requiredHeaders, $importClass, 'shapes', 'shape_import');
    }

    /**
     * Import Backstamps
     */
    public function backstamp_import(Request $request)
    {
        $requiredHeaders = [
            'backstamp_code',
            'name',
            'requestor',
            'customer',
            'status',
            'organic',
            'in_glaze',
            'on_glaze',
            'under_glaze',
            'air_dry',
            'approval_date'
        ];
        $importClass = BackstampsImport::class;
        return $this->processImport($request, $requiredHeaders, $importClass, 'backstamps', 'backstamp_import');
    }

    /**
     * Import Patterns
     */
    public function pattern_import(Request $request)
    {
        $requiredHeaders = [
            'pattern_code',
            'pattern_name',
            'status',
            'customer',
            'requestor',
            'designer',
            'in_glaze',
            'on_glaze',
            'under_glaze',
            'exclusive',
            'approval_date'
        ];
        $importClass = PatternsImport::class;
        return $this->processImport($request, $requiredHeaders, $importClass, 'patterns', 'pattern_import');
    }

    /**
     * Import Glazes
     */
    public function glaze_import(Request $request)
    {
        $requiredHeaders = [
            'glaze_code',
            'inside_code',
            'outside_code',
            'effect_code',
            'status',
            'fire_temp',
            'approval_date'
        ];
        $importClass = GlazesImport::class;
        return $this->processImport($request, $requiredHeaders, $importClass, 'glazes', 'glaze_import');
    }
    /**
     * Process Import
     */
    private function processImport(Request $request, array $requiredHeaders, string $importClass, string $type, string $sessionKey = null)
    {
        // 1. Validate ไฟล์ที่อัปโหลด
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // max 10MB
        ], [
            'file.required' => __('valid.file_required'),
            'file.mimes' => __('valid.file_mimes'),
            'file.max' => __('valid.file_max', ['max' => '10MB']),
        ]);

        if ($validator->fails()) {
            return $this->returnError($request, $validator->errors()->first(), null, $sessionKey);
        }

        $file = $request->file('file');

        try {
            // 2. ตรวจสอบ Header
            $headers = (new HeadingRowImport)->toArray($file)[0][0] ?? [];
            $headers = array_map('strtolower', array_map('trim', $headers));
            $headers = array_filter($headers, function($value) { 
                return $value !== '' && $value !== null && !is_numeric($value); 
            });

            // 3. ตรวจสอบ missing headers
            $missingHeaders = array_diff($requiredHeaders, $headers);
            if (!empty($missingHeaders)) {
                return $this->returnError($request, __('valid.invalid_header', [
                    'required' => implode(', ', $requiredHeaders),
                    'missing' => implode(', ', $missingHeaders),
                ]), null, $sessionKey);
            }

            // 4. ตรวจสอบ extra headers
            $extraHeaders = array_diff($headers, $requiredHeaders);
            if (!empty($extraHeaders)) {
                return $this->returnError($request, __('valid.unknown_columns', [
                    'extra' => implode(', ', $extraHeaders),
                    'required' => implode(', ', $requiredHeaders),
                ]), null, $sessionKey);
            }

            // 5. Import ข้อมูล
            $import = new $importClass;
            Excel::import($import, $file);

            // 6. เช็ค failures
            $failures = $import->getFailures();
            
            if (!empty($failures)) {
                return $this->handleFailures($request, $failures, $sessionKey);
            }

            // 7. สำเร็จ
            return $this->returnSuccess($request, __('valid.import_success', ['type' => __("valid.{$type}")]), $sessionKey);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return $this->handleFailures($request, $e->failures(), $sessionKey);
        } catch (\Exception $e) {
            return $this->returnError($request, __('valid.critical_error') . ': ' . $e->getMessage(), null, $sessionKey);
        }
    }

    /**
     * จัดการ failures
     */
    private function handleFailures(Request $request, $failures, string $sessionKey = null)
    {
        $errorMessages = [];
        $errorCount = is_countable($failures) ? count($failures) : 0;
        
        foreach ($failures as $failure) {
            if (count($errorMessages) < 20) {
                $errorMessages[] = sprintf(
                    __('valid.row') . ' %d [%s]: %s',
                    $failure->row(),
                    $failure->attribute(),
                    implode(', ', $failure->errors())
                );
            }
        }
        
        if ($errorCount > 20) {
            $errorMessages[] = __('valid.and_more', ['count' => $errorCount - 20]);
        }

        return $this->returnError(
            $request,
            __('valid.found_error_count', ['count' => $errorCount]),
            $errorMessages,
            $sessionKey
        );
    }

    /**
     * Return error response
     */
    private function returnError(Request $request, string $message, array $errors = null, string $sessionKey = null)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $errors
            ]);
        }

        $response = redirect()->back()->with('error', $message);
        
        if ($errors) {
            $response->with('import_errors', $errors);
        }

        if ($sessionKey) {
            $response->with($sessionKey, true);
        }
        
        return $response;
    }

    /**
     * Return success response
     */
    private function returnSuccess(Request $request, string $message, string $sessionKey = null)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }

        $response = redirect()->back()->with('success', $message);

        if ($sessionKey) {
            $response->with($sessionKey, true);
        }

        return $response;
    }
}