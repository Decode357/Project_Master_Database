<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
// highlight-start
use Maatwebsite\Excel\HeadingRowImport; // 1. Import Class สำหรับอ่าน Header
// highlight-end

class CustomersImportController extends Controller
{
    /**
     * Import ข้อมูลลูกค้าจากไฟล์ Excel/CSV
     */
    public function import(Request $request)
    {
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
            $headers = array_filter($headers, function($value) { return $value !== '' && $value !== null; });
            // highlight-end

            // 3. ตรวจสอบว่ามี header ที่จำเป็นครบหรือไม่
            $missingHeaders = array_diff($requiredHeaders, $headers);
            if (!empty($missingHeaders)) {
                return redirect()->back()
                    ->with('error', 'Header ไม่ถูกต้อง! ต้องมี: ' . implode(', ', $requiredHeaders) .
                                '. หาไม่เจอ: ' . implode(', ', $missingHeaders));
            }

            // 4. ตรวจสอบว่า header มีเฉพาะที่กำหนดไว้หรือไม่
            $extraHeaders = array_diff($headers, $requiredHeaders);
            if (!empty($extraHeaders)) {
                return redirect()->back()
                    ->with('error', 'พบคอลัมน์ที่ไม่รู้จัก: ' . implode(', ', $extraHeaders) .
                                '. กรุณาใช้เฉพาะ: ' . implode(', ', $requiredHeaders));
            }

            // 5. ตรวจสอบไฟล์ว่าง (ย้ายไปเช็คใน Import Class หรือใช้ WithEmptyRows concern)
            // การตรวจสอบ getHighestRow() จะทำให้ไฟล์ถูกอ่านอีกครั้ง
            // แนะนำให้ใช้ Maatwebsite/Excel จัดการ

            // 6. ถ้า header ถูกต้อง ค่อย import
            $import = new CustomersImport;
            Excel::import($import, $file);

            // 7. จัดการกับแถวที่ล้มเหลว (หาก Import Class ใช้ SkipsOnFailure)
            // (ในโค้ดนี้ เราจะลบส่วนนี้ออก เพราะเราจะจับที่ ValidationException)

            // 8. สำเร็จทั้งหมด
            return redirect()->back()
                ->with('success', 'นำเข้าข้อมูลลูกค้าสำเร็จ!');
                // (ไม่ควรนับ row ที่นี่ เพราะไฟล์ถูกอ่านไปแล้ว ให้ไปนับใน Import Class)

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // 9. จับ Validation errors จาก Import Class (เช่น email ซ้ำ, name ว่าง)
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                // $failure->row() // แถวที่เกิดปัญหา
                // $failure->attribute() // คอลัมน์ที่เกิดปัญหา
                // $failure->errors() // Array ของข้อผิดพลาด
                $errorMessages[] = "แถว {$failure->row()}: " . implode(', ', $failure->errors());
            }

            return redirect()->back()
                ->with('error', 'พบข้อผิดพลาดในการ validate ข้อมูลบางแถว (ข้อมูลจะไม่ถูก Import จนกว่าจะแก้ไขทั้งหมด)')
                ->with('import_errors', $errorMessages); // ใช้ key 'import_errors'

        } catch (\Exception $e) {
            // 10. Error อื่นๆ (เช่น เชื่อมต่อ DB ไม่ได้, ฯลฯ)
            return redirect()->back()
                ->with('error', 'เกิดข้อผิดพลาดร้ายแรง: ' . $e->getMessage());
        }
    }
}