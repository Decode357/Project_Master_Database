<?php

namespace App\Services;

use App\Models\Requestor;
use App\Models\Customer;
use App\Models\Status;
use App\Models\Designer;
use App\Models\GlazeInside;
use App\Models\GlazeOuter;
use App\Models\Effect;

class ImportHelperService
{
    private $requestorsCache = [];
    private $customersCache = [];
    private $statusesCache = [];
    private $designersCache = [];
    private $glazeInsidesCache = [];
    private $glazeOutersCache = [];
    private $effectsCache = [];

    public function __construct()
    {
        $this->loadAllCaches();
    }

    /**
     * โหลดข้อมูลทั้งหมดลง Cache
     */
    private function loadAllCaches(): void
    {
        // Requestor
        $this->requestorsCache = Requestor::pluck('id', 'name')->toArray();
        
        // Customer - lowercase key
        $customers = Customer::all();
        foreach ($customers as $customer) {
            $this->customersCache[strtolower($customer->name)] = $customer->id;
        }
        
        // Status - lowercase key
        $statuses = Status::all();
        foreach ($statuses as $status) {
            $this->statusesCache[strtolower($status->status)] = $status->id;
        }

        // Designer - lowercase key
        $designers = Designer::all();
        foreach ($designers as $designer) {
            $this->designersCache[strtolower($designer->designer_name)] = $designer->id;
        }

        // GlazeInside - lowercase key
        $glazeInsides = GlazeInside::all();
        foreach ($glazeInsides as $glazeInside) {
            $this->glazeInsidesCache[strtolower($glazeInside->glaze_inside_code)] = $glazeInside->id;
        }

        // GlazeOuter - lowercase key
        $glazeOuters = GlazeOuter::all();
        foreach ($glazeOuters as $glazeOuter) {
            $this->glazeOutersCache[strtolower($glazeOuter->glaze_outer_code)] = $glazeOuter->id;
        }

        // Effect - lowercase key
        $effects = Effect::all();
        foreach ($effects as $effect) {
            $this->effectsCache[strtolower($effect->effect_code)] = $effect->id;
        }

        // Designer - lowercase key
        $designers = Designer::all();
        foreach ($designers as $designer) {
            $this->designersCache[strtolower($designer->designer_name)] = $designer->id;
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
     * หา Designer หรือสร้างใหม่ถ้าไม่เจอ
     */
    public function getOrCreateDesigner(string $name): int
    {
        $nameLower = strtolower(trim($name));
        
        if (isset($this->designersCache[$nameLower])) {
            return $this->designersCache[$nameLower];
        }

        $designer = Designer::firstOrCreate(
            ['designer_name' => $name],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $this->designersCache[$nameLower] = $designer->id;

        return $designer->id;
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
     * หา GlazeInside แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findGlazeInsideCaseInsensitive(string $glazeInside): ?int
    {
        $glazeInsideLower = strtolower(trim($glazeInside));
        return $this->glazeInsidesCache[$glazeInsideLower] ?? null;
    }

    /**
     * หา GlazeOuter แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findGlazeOuterCaseInsensitive(string $glazeOuter): ?int
    {
        $glazeOuterLower = strtolower(trim($glazeOuter));
        return $this->glazeOutersCache[$glazeOuterLower] ?? null;
    }

    /**
     * หา Effect แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findEffectCaseInsensitive(string $effect): ?int
    {
        $effectLower = strtolower(trim($effect));
        return $this->effectsCache[$effectLower] ?? null;
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
}