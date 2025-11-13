<?php

namespace App\Imports;

use App\Models\Glaze;
use App\Services\ImportHelperService;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class GlazesImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    private $failures = [];
    private $rowsData = [];
    private $importHelper;

    public function __construct()
    {
        $this->importHelper = new ImportHelperService();
    }

    /**
     * เก็บข้อมูลทั้งหมดไว้ก่อน ไม่บันทึกทันที
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;
            $hasErrors = false;

            // แปลง approval_date จาก Excel format ก่อน validate
            if (!empty($row['approval_date'])) {
                $row['approval_date'] = $this->parseExcelDate($row['approval_date']);
            }

            // 1. เช็ค relations แบบ fast lookup
            $relationErrors = [];

            // เช็ค status (case-insensitive)
            if (!empty($row['status'])) {
                $statusId = $this->importHelper->findStatusCaseInsensitive($row['status']);
                if ($statusId === null) {
                    $relationErrors[] = __('valid.err.status.not_found', ['name' => $row['status']]);
                } else {
                    $row['status_id'] = $statusId;
                }
            }

            // เช็ค glaze_inside (case-insensitive)
            if (!empty($row['inside_code'])) {
                $insideCodeId = $this->importHelper->findGlazeInsideCaseInsensitive($row['inside_code']);
                if ($insideCodeId === null) {
                    $relationErrors[] = __('valid.err.glaze_inside.not_found', ['name' => $row['inside_code']]);
                } else {
                    $row['glaze_inside_id'] = $insideCodeId;
                }
            }

            // เช็ค glaze_outside (case-insensitive)
            if (!empty($row['outside_code'])) {
                $outsideCodeId = $this->importHelper->findGlazeOuterCaseInsensitive($row['outside_code']);
                if ($outsideCodeId === null) {
                    $relationErrors[] = __('valid.err.glaze_outside.not_found', ['name' => $row['outside_code']]);
                } else {
                    $row['glaze_outer_id'] = $outsideCodeId;
                }
            }

            // เช็ค effect (case-insensitive)
            if (!empty($row['effect_code'])) {
                $effectId = $this->importHelper->findEffectCaseInsensitive($row['effect_code']);
                if ($effectId === null) {
                    $relationErrors[] = __('valid.err.effect_code.not_found', ['name' => $row['effect_code']]);
                } else {
                    $row['effect_id'] = $effectId;
                }
            }

            // ถ้ามี relation errors ให้เก็บไว้
            if (!empty($relationErrors)) {
                $this->failures[] = new Failure(
                    $rowNumber,
                    'relations',
                    $relationErrors,
                    $row->toArray()
                );
                $hasErrors = true;
            }

            // 2. เช็ค validation ทั่วไป
            $validator = Validator::make($row->toArray(), $this->rules(), $this->customValidationMessages());
            
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $attribute => $errors) {
                    $this->failures[] = new Failure(
                        $rowNumber,
                        $attribute,
                        $errors,
                        $row->toArray()
                    );
                }
                $hasErrors = true;
            }

            // 3. ถ้าไม่มี error เก็บข้อมูลไว้
            if (!$hasErrors) {
                $this->rowsData[] = $row->toArray();
            }
        }

        // ถ้าไม่มี failures เลย ค่อยบันทึกข้อมูลทั้งหมด
        if (empty($this->failures)) {
            $this->batchUpsert();
        }
    }

    /**
     * Batch Upsert - บันทึกข้อมูลทั้งหมดพร้อมกัน
     */
    private function batchUpsert()
    {
        $data = [];
        $now = now();
        
        foreach ($this->rowsData as $row) {
            $data[] = [
                'glaze_code' => $row['glaze_code'],
                'glaze_inside_id' => $row['glaze_inside_id'] ?? null,
                'glaze_outer_id' => $row['glaze_outer_id'] ?? null,
                'effect_id' => $row['effect_id'] ?? null,
                'status_id' => $row['status_id'] ?? null,
                'fire_temp' => $row['fire_temp'],
                'approval_date' => $row['approval_date'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // แบ่งเป็น chunks ละ 500 แถว เพื่อป้องกัน query ใหญ่เกินไป
        foreach (array_chunk($data, 500) as $chunk) {
            Glaze::upsert(
                $chunk,
                ['glaze_code'],
                [
                    'glaze_inside_id',
                    'glaze_outer_id',
                    'effect_id',
                    'status_id',
                    'fire_temp',
                    'approval_date',
                    'updated_at'
                ]
            );
        }
    }

    /**
     * ดึง failures ทั้งหมด
     */
    public function getFailures()
    {
        return $this->failures;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'glaze_code' => 'required|max:255',
            'glaze_inside_code' => 'nullable|max:255',
            'glaze_outer_code' => 'nullable|max:255',
            'effect_code' => 'nullable|max:255',
            'status' => 'nullable|max:255',
            'fire_temp' => 'nullable|max:255',
            'approval_date' => 'nullable|date_format:Y-m-d',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'glaze_code.required' => __('valid.err.glaze_code.required'),
            'glaze_inside_code.max' => __('valid.err.glaze_inside_code.max'),
            'glaze_outer_code.max' => __('valid.err.glaze_outer_code.max'),
            'effect_code.max' => __('valid.err.effect_code.max'),
            'status.max' => __('valid.err.status.max'),
            'fire_temp.max' => __('valid.err.fire_temp.max'),
            'approval_date.date_format' => __('valid.err.approval_date.date'),
        ];
    }

    /**
     * แปลงวันที่จาก Excel ให้เป็น Y-m-d format
     */
    private function parseExcelDate($date)
    {
        if (empty($date) || is_null($date)) {
            return null;
        }

        try {
            if (is_numeric($date)) {
                $unixDate = ExcelDate::excelToTimestamp($date);
                return Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
            }

            if ($date instanceof \DateTime) {
                return $date->format('Y-m-d');
            }

            if (is_string($date)) {
                $date = trim($date);
                
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                    return $date;
                }
                
                return Carbon::parse($date)->format('Y-m-d');
            }

            return null;
        } catch (\Exception $e) {
            return $date;
        }
    }
}
