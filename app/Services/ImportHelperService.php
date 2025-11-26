<?php
// ImportHelperService.php ใช้สำหรับช่วยในการโหลดข้อมูลความสัมพันธ์ (relations) ต่างๆ แบบมีประสิทธิภาพและลดจำนวน query ที่เกิดขึ้นซ้ำๆ ในระหว่างการนำเข้าข้อมูล (importing data) จากไฟล์ Excel
namespace App\Services;

use App\Models\{
    Requestor, Customer, Status,
    Designer, GlazeInside, GlazeOuter,
    Effect, ShapeType, ShapeCollection,
    ItemGroup, Process
};

class ImportHelperService
{
    private $requestorsCache = [];
    private $customersCache = [];
    private $statusesCache = [];
    private $designersCache = [];
    private $glazeInsidesCache = [];
    private $glazeOutersCache = [];
    private $effectsCache = [];
    private $shapeTypesCache = [];
    private $shapeCollectionsCache = [];
    private $itemGroupsCache = [];
    private $processesCache = [];
    
    // Flags เพื่อเช็คว่าโหลดแล้วหรือยัง
    private $loadedCaches = [];

    public function __construct()
    {
        // ไม่โหลดอะไรเลยตอน construct
    }

    /**
     * โหลด Requestor Cache
     */
    private function loadRequestorsCache(): void
    {
        if (!isset($this->loadedCaches['requestors'])) {
            $requestors = Requestor::all(['id', 'name']);
            foreach ($requestors as $requestor) {
                $this->requestorsCache[strtolower($requestor->name)] = $requestor->id;
            }
            $this->loadedCaches['requestors'] = true;
        }
    }

    /**
     * โหลด Customer Cache
     */
    private function loadCustomersCache(): void
    {
        if (!isset($this->loadedCaches['customers'])) {
            $customers = Customer::all(['id', 'name']);
            foreach ($customers as $customer) {
                $this->customersCache[strtolower($customer->name)] = $customer->id;
            }
            $this->loadedCaches['customers'] = true;
        }
    }

    /**
     * โหลด Status Cache
     */
    private function loadStatusesCache(): void
    {
        if (!isset($this->loadedCaches['statuses'])) {
            $statuses = Status::all(['id', 'status']);
            foreach ($statuses as $status) {
                $this->statusesCache[strtolower($status->status)] = $status->id;
            }
            $this->loadedCaches['statuses'] = true;
        }
    }

    /**
     * โหลด Designer Cache
     */
    private function loadDesignersCache(): void
    {
        if (!isset($this->loadedCaches['designers'])) {
            $designers = Designer::all(['id', 'designer_name']);
            foreach ($designers as $designer) {
                $this->designersCache[strtolower($designer->designer_name)] = $designer->id;
            }
            $this->loadedCaches['designers'] = true;
        }
    }

    /**
     * โหลด GlazeInside Cache
     */
    private function loadGlazeInsidesCache(): void
    {
        if (!isset($this->loadedCaches['glazeInside'])) {
            $glazeInsides = GlazeInside::all(['id', 'glaze_inside_code']);
            foreach ($glazeInsides as $glazeInside) {
                $this->glazeInsidesCache[strtolower($glazeInside->glaze_inside_code)] = $glazeInside->id;
            }
            $this->loadedCaches['glazeInside'] = true;
        }
    }

    /**
     * โหลด GlazeOuter Cache
     */
    private function loadGlazeOutersCache(): void
    {
        if (!isset($this->loadedCaches['glazeOuter'])) {
            $glazeOuters = GlazeOuter::all(['id', 'glaze_outer_code']);
            foreach ($glazeOuters as $glazeOuter) {
                $this->glazeOutersCache[strtolower($glazeOuter->glaze_outer_code)] = $glazeOuter->id;
            }
            $this->loadedCaches['glazeOuter'] = true;
        }
    }

    /**
     * โหลด Effect Cache
     */
    private function loadEffectsCache(): void
    {
        if (!isset($this->loadedCaches['effects'])) {
            $effects = Effect::all(['id', 'effect_code']);
            foreach ($effects as $effect) {
                $this->effectsCache[strtolower($effect->effect_code)] = $effect->id;
            }
            $this->loadedCaches['effects'] = true;
        }
    }

    /**
     * โหลด ShapeType Cache
     */
    private function loadShapeTypesCache(): void
    {
        if (!isset($this->loadedCaches['shapeTypes'])) {
            $shapeTypes = ShapeType::all(['id', 'name']);
            foreach ($shapeTypes as $shapeType) {
                $this->shapeTypesCache[strtolower($shapeType->name)] = $shapeType->id;
            }
            $this->loadedCaches['shapeTypes'] = true;
        }
    }

    /**
     * โหลด ShapeCollection Cache
     */
    private function loadShapeCollectionsCache(): void
    {
        if (!isset($this->loadedCaches['shapeCollections'])) {
            $shapeCollections = ShapeCollection::all(['id', 'collection_code']);
            foreach ($shapeCollections as $shapeCollection) {
                $this->shapeCollectionsCache[strtolower($shapeCollection->collection_code)] = $shapeCollection->id;
            }
            $this->loadedCaches['shapeCollections'] = true;
        }
    }

    /**
     * โหลด ItemGroup Cache
     */
    private function loadItemGroupsCache(): void
    {
        if (!isset($this->loadedCaches['itemGroups'])) {
            $itemGroups = ItemGroup::all(['id', 'item_group_name']);
            foreach ($itemGroups as $itemGroup) {
                $this->itemGroupsCache[strtolower($itemGroup->item_group_name)] = $itemGroup->id;
            }
            $this->loadedCaches['itemGroups'] = true;
        }
    }

    /**
     * โหลด Process Cache
     */
    private function loadProcessesCache(): void
    {
        if (!isset($this->loadedCaches['processes'])) {
            $processes = Process::all(['id', 'process_name']);
            foreach ($processes as $process) {
                $this->processesCache[strtolower($process->process_name)] = $process->id;
            }
            $this->loadedCaches['processes'] = true;
        }
    }

    /**
     * หา Requestor หรือสร้างใหม่ถ้าไม่เจอ
     */
    public function getOrCreateRequestor(string $name): int
    {
        $this->loadRequestorsCache();
        $nameLower = strtolower(trim($name)); // เพิ่มบรรทัดนี้
        
        if (isset($this->requestorsCache[$nameLower])) {
            return $this->requestorsCache[$nameLower];
        }

        $requestor = Requestor::firstOrCreate(
            ['name' => $name],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $this->requestorsCache[$name] = $requestor->id;

        return $requestor->id;
    }

    /**
     * หา Designer หรือสร้างใหม่ถ้าไม่เจอ
     */
    public function getOrCreateDesigner(string $name): int
    {
        $this->loadDesignersCache();
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
     * หา Process หรือสร้างใหม่ถ้าไม่เจอ
     */
    public function getOrCreateProcess(string $name): int
    {
        $this->loadProcessesCache();
        $nameLower = strtolower(trim($name));
        
        if (isset($this->processesCache[$nameLower])) {
            return $this->processesCache[$nameLower];
        }

        $process = Process::firstOrCreate(
            ['process_name' => $name],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $this->processesCache[$nameLower] = $process->id;

        return $process->id;
    }

    /** 
    * หา ItemGroup แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
    */
    public function findItemGroupCaseInsensitive(string $name): ?int
    {
        $this->loadItemGroupsCache();
        $nameLower = strtolower(trim($name));
        return $this->itemGroupsCache[$nameLower] ?? null;
    }
    
    /**
     * หา Customer แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findCustomerCaseInsensitive(string $name): ?int
    {
        $this->loadCustomersCache();
        $nameLower = strtolower(trim($name));
        return $this->customersCache[$nameLower] ?? null;
    }

    /**
     * หา Status แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findStatusCaseInsensitive(string $status): ?int
    {
        $this->loadStatusesCache();
        $statusLower = strtolower(trim($status));
        return $this->statusesCache[$statusLower] ?? null;
    }

    /**
     * หา GlazeInside แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findGlazeInsideCaseInsensitive(string $glazeInside): ?int
    {
        $this->loadGlazeInsidesCache();
        $glazeInsideLower = strtolower(trim($glazeInside));
        return $this->glazeInsidesCache[$glazeInsideLower] ?? null;
    }

    /**
     * หา GlazeOuter แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findGlazeOuterCaseInsensitive(string $glazeOuter): ?int
    {
        $this->loadGlazeOutersCache();
        $glazeOuterLower = strtolower(trim($glazeOuter));
        return $this->glazeOutersCache[$glazeOuterLower] ?? null;
    }

    /**
     * หา Effect แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findEffectCaseInsensitive(string $effect): ?int
    {
        $this->loadEffectsCache();
        $effectLower = strtolower(trim($effect));
        return $this->effectsCache[$effectLower] ?? null;
    }

    /**
     * หา ShapeType แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findShapeTypeCaseInsensitive(string $shapeType): ?int
    {
        $this->loadShapeTypesCache();
        $shapeTypeLower = strtolower(trim($shapeType));
        return $this->shapeTypesCache[$shapeTypeLower] ?? null;
    }

    /**
     * หา ShapeCollection แบบไม่สนใจตัวพิมพ์เล็ก-ใหญ่
     */
    public function findShapeCollectionCaseInsensitive(string $shapeCollection): ?int
    {
        $this->loadShapeCollectionsCache();
        $shapeCollectionLower = strtolower(trim($shapeCollection));
        return $this->shapeCollectionsCache[$shapeCollectionLower] ?? null;
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