<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\HeadingRowImport; // 1. Import Class สำหรับอ่าน Header

class CustomersImportController extends Controller
{
    public function import(Request $request)
    {
// ขนาดไฟล์สูงสุดที่รองรับ: 10MB
// CSV (ASCII) ≈ 105,916 records
// CSV (ชื่อ 40 ตัวเป็นไทย) ≈ 58,579 records
// XLSX (อังกฤษ, ประมาณ) ≈ ~35,000 – 52,000 records (ค่าใกล้เคียง ≈ 42,366 ถ้า factor 2.5)
// XLSX (ไทย, ประมาณ) ≈ ~19,000 – 29,000 records (ค่าใกล้เคียง ≈ 24,138 ถ้า factor 2.5)
        // 1. Validate ไฟล์ที่อัปโหลด
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // max 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        
        // Header ที่ต้องการ
        $requiredHeaders = ['code', 'name', 'email', 'phone'];

        try {
            // highlight-start
            // 2. ตรวจสอบ Header โดยใช้ HeadingRowImport (อ่านเฉพาะแถวแรก)
            $headers = (new HeadingRowImport)->toArray($file)[0][0] ?? []; // [0][0] เพื่อเข้าถึงแถวแรกของ Sheet แรก
            
            // ทำให้เป็นตัวพิมพ์เล็กและ trim
            $headers = array_map('strtolower', array_map('trim', $headers));
            
            // กรอง header ที่เป็นค่าว่าง (null หรือ '') ออก
            $headers = array_filter($headers, function($value) { return $value !== '' && $value !== null && !is_numeric($value); });
            // highlight-end

            // 3. ตรวจสอบว่ามี header ที่จำเป็นครบหรือไม่
            $missingHeaders = array_diff($requiredHeaders, $headers);
            if (!empty($missingHeaders)) {
                return redirect()->back()
                    ->with('error', __('valid.invalid_header', [
                        'required' => implode(', ', $requiredHeaders),
                        'missing' => implode(', ', $missingHeaders),
                    ]));
            }

            // 4. ตรวจสอบว่า header มีเฉพาะที่กำหนดไว้หรือไม่
            $extraHeaders = array_diff($headers, $requiredHeaders);
            if (!empty($extraHeaders)) {
                return redirect()->back()
                    ->with('error', __('valid.unknown_columns', [
                        'extra' => implode(', ', $extraHeaders),
                        'required' => implode(', ', $requiredHeaders),
                    ]));
            }

            // 5. ตรวจสอบไฟล์ว่าง (ย้ายไปเช็คใน Import Class หรือใช้ WithEmptyRows concern)
            // การตรวจสอบ getHighestRow() จะทำให้ไฟล์ถูกอ่านอีกครั้ง
            // แนะนำให้ใช้ Maatwebsite/Excel จัดการ

            // 6. ถ้า header ถูกต้อง ค่อย import
            $import = new CustomersImport;
            Excel::import($import, $file);

            // 7. เช็ค failures ที่เก็บไว้
            $failures = $import->getFailures();
            
            if (!empty($failures)) {
                $errorMessages = [];
                $errorCount = count($failures);
                
                foreach ($failures as $failure) {
                    // จำกัดแสดงแค่ 20 errors แรก
                    if (count($errorMessages) < 20) {
                        $errorMessages[] = sprintf(
                            __('valid.row'). ' %d [%s]: %s',  // ดึงข้อความจากไฟล์ภาษา
                            $failure->row(),
                            $failure->attribute(),
                            implode(', ', $failure->errors())
                        );
                    }
                }
                
                // ถ้ามี error เกิน 20 ให้แจ้งเตือน
                if ($errorCount > 20) {
                    $errorMessages[] = __('valid.and_more', ['count' => $errorCount - 20]);
                }

                return redirect()->back()
                    ->with('error', __('valid.found_error_count', ['count' => $errorCount]))
                    ->with('import_errors', $errorMessages);
            }

            // 8. สำเร็จทั้งหมด
            return redirect()->back()
                ->with('success', __('valid.import_success'));

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // 9. จับ Validation errors (สำรอง - ไม่ควรมาถึงตรงนี้)
            $failures = $e->failures();
            $errorMessages = [];
            $errorCount = 0;
            
            foreach ($failures as $failure) {
                $errorCount++;
                
                if ($errorCount <= 20) {
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

            return response()->json([
                'success' => false,
                'message' => __('valid.found_error_count', ['count' => $errorCount]),
                'errors' => $errorMessages
            ]);

        } catch (\Exception $e) {
            // 10. Error อื่นๆ
            return response()->json([
                'success' => false,
                'message' => __('valid.critical_error') . ': ' . $e->getMessage()
            ]);
        }
    }
}