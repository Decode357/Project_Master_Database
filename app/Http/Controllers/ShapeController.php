<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\{
    Shape, ShapeType, Status, ShapeCollection, Customer,
    ItemGroup, Process, Designer, Requestor, Image
};

class ShapeController extends Controller
{
    public function shapeindex(Request $request)
    {
        $relations = [
            'shapeType', 'status', 'shapeCollection', 'customer',
            'itemGroup', 'process', 'designer', 'requestor', 'updater','images'
        ];

        // รับค่า perPage จาก request หรือใช้ default 10
        $perPage = $request->get('per_page', 10);
        // จำกัดค่า perPage ที่อนุญาต
        $allowedPerPage = [5, 10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        // รับค่า search
        $search = $request->get('search');
        $query = Shape::with($relations);
        // เพิ่ม search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('item_code', 'LIKE', "%{$search}%")
                ->orWhereHas('shapeType', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('shapeCollection', function($q) use ($search) {
                    $q->where('collection_name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('customer', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('itemGroup', function($q) use ($search) {
                    $q->where('item_group_name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('process', function($q) use ($search) {
                    $q->where('process_name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('designer', function($q) use ($search) {
                    $q->where('designer_name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('requestor', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('status', function($q) use ($search) {
                    $q->where('status', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('updater', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $shapes = $query->latest()->paginate($perPage)->appends($request->query());

        $data = [
            'shapeTypes' => ShapeType::all(),
            'statuses' => Status::all(),
            'shapeCollections' => ShapeCollection::all(),
            'customers' => Customer::all(),
            'itemGroups' => ItemGroup::all(),
            'processes' => Process::all(),
            'designers' => Designer::all(),
            'requestors' => Requestor::all(),
        ];

        $permissions = $this->getUserPermissions();

        return view('shape', array_merge($data, compact('shapes', 'perPage', 'search'), $permissions));
    }

    private function handleNewSelectableData(array &$data)
    {
        $mapping = [
            'process_id' => [\App\Models\Process::class, 'process_name'],
            'item_group_id' => [\App\Models\ItemGroup::class, 'item_group_name'],
            'requestor_id' => [\App\Models\Requestor::class, 'name'],
            'designer_id' => [\App\Models\Designer::class, 'designer_name'],
        ];
        foreach ($mapping as $field => [$model, $column]) {
            if (!empty($data[$field])) {
                $value = $data[$field];
                // ถ้าเป็นตัวเลข ให้เช็กว่า ID นั้นมีจริงไหม
                if (is_numeric($value)) {
                    $exists = $model::where('id', $value)->exists();
                    if (!$exists) {
                        // ถ้าไม่มีจริง ให้สร้างใหม่โดยใช้เลขนั้นเป็นชื่อ
                        $record = $model::create([$column => (string)$value]);
                        $data[$field] = $record->id;
                    }
                } else {
                    // ถ้าไม่ใช่ตัวเลข → เป็นชื่อใหม่แน่นอน → สร้างใหม่
                    $record = $model::create([$column => $value]);
                    $data[$field] = $record->id;
                }
            }
        }
        // Process
        if (!empty($data['process_id']) && !is_numeric($data['process_id'])) {
            $process = Process::create(['process_name' => $data['process_id']]);
            $data['process_id'] = $process->id;
        }
        // Item Group
        if (!empty($data['item_group_id']) && !is_numeric($data['item_group_id'])) {
            $itemGroup = ItemGroup::create(['item_group_name' => $data['item_group_id']]);
            $data['item_group_id'] = $itemGroup->id;
        }
        // Requestor
        if (!empty($data['requestor_id']) && !is_numeric($data['requestor_id'])) {
            $requestor = Requestor::create(['name' => $data['requestor_id']]);
            $data['requestor_id'] = $requestor->id;
        }
        // Designer
        if (!empty($data['designer_id']) && !is_numeric($data['designer_id'])) {
            $designer = Designer::create(['designer_name' => $data['designer_id']]);
            $data['designer_id'] = $designer->id;
        }
    }

    private function rules($id = null)
    {
        $unique = $id ? ",$id" : '';
        return [
            'item_code' => "required|string|max:255|unique:shapes,item_code{$unique}",
            'item_description_thai' => 'nullable|string|max:255',
            'item_description_eng'  => 'nullable|string|max:255',
            'shape_type_id' => 'nullable|exists:shape_types,id',
            'status_id'     => 'nullable|exists:statuses,id',
            'process_id'    => 'nullable',
            'item_group_id' => 'nullable',
            'requestor_id'  => 'nullable',
            'customer_id'   => 'nullable|exists:customers,id',
            'designer_id'   => 'nullable',
            'shape_collection_id' => 'nullable|exists:shape_collections,id',
            'volume'        => 'nullable|numeric',
            'weight'        => 'nullable|numeric',
            'long_diameter' => 'nullable|numeric',
            'short_diameter'=> 'nullable|numeric',
            'height_long'   => 'nullable|numeric',
            'height_short'  => 'nullable|numeric',
            'body'          => 'nullable|numeric',
            'approval_date' => 'nullable|date',
        ];
    }

    public function storeShape(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['updated_by'] = auth()->id();
        $this->handleNewSelectableData($data);
        $shape = Shape::create($data);
        // จัดการรูปภาพ
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $fileName = $image->getClientOriginalName();
                $filePath = $image->store('shapes', 'public');
                
                $shape->images()->create([
                    'file_name' => $fileName,
                    'file_path' => $filePath
                ]);
            }
        }

        return response()->json([
            'status' => 'success', 
            'message' => 'Shape created successfully!', 
            'shape' => $shape->load('images')
        ], 201);
    }

    public function updateShape(Request $request, Shape $shape)
    {
        $data = $request->validate($this->rules($shape->id));
        $data['updated_by'] = auth()->id();
        $this->handleNewSelectableData($data);
        $shape->update($data);
        // จัดการรูปภาพใหม่
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $fileName = $image->getClientOriginalName();
                $filePath = $image->store('shapes', 'public');
                
                $shape->images()->create([
                    'file_name' => $fileName,
                    'file_path' => $filePath
                ]);
            }
        }

        // ลบรูปภาพที่ต้องการลบ
        if ($request->deleted_images) {
            $deletedImages = json_decode($request->deleted_images);
            foreach ($deletedImages as $imageId) {
                $image = Image::find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->file_path);
                    $image->delete();
                }
            }
        }

        return response()->json([
            'status' => 'success', 
            'message' => 'Shape updated successfully!', 
            'shape' => $shape->load('images')
        ], 200);
    }

    public function destroyShape(Shape $shape)
    {
        $shape->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Shape deleted successfully.'
        ]);
    }
}
