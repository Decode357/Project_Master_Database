<?php

namespace App\Services;

use App\Models\Requestor;
use App\Models\Customer;
use App\Models\Status;
use Illuminate\Support\Collection;

class ImportHelperService
{
    private $requestorsCache = [];
    private $customersCache = [];
    private $statusesCache = [];

    public function __construct()
    {
        $this->loadAllCaches();
    }

    /**
     * โหลดข้อมูลทั้งหมดลง Cache - แก้ไขแล้ว
     */
    private function loadAllCaches(): void
    {
        // Requestor - ใช้ name เป็น key
        $this->requestorsCache = Requestor::pluck('id', 'name')->toArray();
        
        // Customer - ใช้ lowercase name เป็น key ✅
        $customers = Customer::all();
        foreach ($customers as $customer) {
            $this->customersCache[strtolower($customer->name)] = $customer->id;
        }
        
        // Status - ใช้ lowercase status เป็น key ✅
        $statuses = Status::all();
        foreach ($statuses as $status) {
            $this->statusesCache[strtolower($status->status)] = $status->id;
        }
    }

    /**
     * รีโหลด Cache ใหม่
     */
    public function refreshCaches(): void
    {
        $this->loadAllCaches();
    }

    /**
     * หา Requestor หรือสร้างใหม่ถ้าไม่เจอ
     */
    public function getOrCreateRequestor(string $name): int
    {
        $name = trim($name);
        
        // เช็คใน cache ก่อน
        if (isset($this->requestorsCache[$name])) {
            return $this->requestorsCache[$name];
        }

        // ถ้าไม่เจอให้สร้างใหม่
        $requestor = Requestor::firstOrCreate(
            ['name' => $name],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // อัพเดท cache
        $this->requestorsCache[$name] = $requestor->id;

        return $requestor->id;
    }

    /**
     * หา Customer แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findCustomerCaseInsensitive(string $name): ?int
    {
        $nameLower = strtolower(trim($name));
        
        return $this->customersCache[$nameLower] ?? null;
    }

    /**
     * หา Status แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findStatusCaseInsensitive(string $status): ?int
    {
        $statusLower = strtolower(trim($status));
        
        return $this->statusesCache[$statusLower] ?? null;
    }

    /**
     * หา Customer หลายตัวพร้อมกัน
     */
    public function findMultipleCustomers(array $names): array
    {
        $results = [];
        
        foreach ($names as $name) {
            $id = $this->findCustomerCaseInsensitive($name);
            if ($id !== null) {
                $results[$name] = $id;
            }
        }
        
        return $results;
    }

    /**
     * หา Status หลายตัวพร้อมกัน
     */
    public function findMultipleStatuses(array $statuses): array
    {
        $results = [];
        
        foreach ($statuses as $status) {
            $id = $this->findStatusCaseInsensitive($status);
            if ($id !== null) {
                $results[$status] = $id;
            }
        }
        
        return $results;
    }

    /**
     * สร้าง Requestors หลายตัวพร้อมกัน
     */
    public function createMultipleRequestors(array $names): array
    {
        $results = [];
        
        foreach ($names as $name) {
            $results[$name] = $this->getOrCreateRequestor($name);
        }
        
        return $results;
    }

    /**
     * แปลงค่าเป็น Boolean (0 หรือ 1)
     */
    public function convertToBoolean($value): int
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        if (is_numeric($value)) {
            return (int)$value > 0 ? 1 : 0;
        }

        $value = strtolower(trim($value));
        
        if (in_array($value, ['true', 'yes', '1', 'ใช่', 'y'])) {
            return 1;
        }

        return 0;
    }

    /**
     * ตรวจสอบว่ามี Requestor อยู่หรือไม่
     */
    public function requestorExists(string $name): bool
    {
        return isset($this->requestorsCache[$name]);
    }

    /**
     * ตรวจสอบว่ามี Customer อยู่หรือไม่
     */
    public function customerExists(string $name): bool
    {
        return $this->findCustomerCaseInsensitive($name) !== null;
    }

    /**
     * ตรวจสอบว่ามี Status อยู่หรือไม่
     */
    public function statusExists(string $status): bool
    {
        return $this->findStatusCaseInsensitive($status) !== null;
    }

    /**
     * ดึงรายชื่อ Requestors ทั้งหมด
     */
    public function getAllRequestors(): array
    {
        return array_keys($this->requestorsCache);
    }

    /**
     * ดึงรายชื่อ Customers ทั้งหมด
     */
    public function getAllCustomers(): array
    {
        return array_keys($this->customersCache);
    }

    /**
     * ดึงรายชื่อ Statuses ทั้งหมด
     */
    public function getAllStatuses(): array
    {
        return array_keys($this->statusesCache);
    }
}