<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{
    Backstamp, Status, Image,
    Requestor, Customer
};

class BackstampController extends Controller
{
    public function backstampindex(Request $request)
    {
        $relations = [
            'requestor', 'customer', 'status', 'updater', 'images'
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
            $query = Backstamp::with($relations);
        // เพิ่ม search functionality 
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('backstamp_code', 'LIKE', "%{$search}%")
                ->orWhereHas('requestor', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('customer', function($q) use ($search) {
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

        $backstamps = $query->latest()->paginate($perPage)->appends($request->query());

        $data = [
            'statuses'   => Status::all(),
            'requestors' => Requestor::all(),
            'customers'  => Customer::all(),
        ];
        $permissions = $this->getUserPermissions();
        return view('backstamp', array_merge($data, compact('backstamps', 'perPage', 'search'), $permissions));
    }

    private function handleNewSelectableData(array &$data)
    {
        $mapping = [
            'requestor_id' => [\App\Models\Requestor::class, 'name'],
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
        // Requestor
        if (!empty($data['requestor_id']) && !is_numeric($data['requestor_id'])) {
            $requestor = Requestor::create(['name' => $data['requestor_id']]);
            $data['requestor_id'] = $requestor->id;
        }
    }

    private function rules($id = null)
    {
        return [
            'backstamp_code' => [
                'required', 'string', 'max:255',
                Rule::unique('backstamps', 'backstamp_code')->ignore($id),
            ],
            'name'           => 'nullable|string|max:255',
            'requestor_id'   => 'nullable',
            'customer_id'    => 'nullable|exists:customers,id',
            'status_id'      => 'nullable|exists:statuses,id',
            'in_glaze'       => 'nullable|boolean',
            'on_glaze'       => 'nullable|boolean',
            'under_glaze'    => 'nullable|boolean',
            'air_dry'        => 'nullable|boolean',
            'organic'        => 'nullable|boolean',
            'approval_date'  => 'nullable|date',
        ];
    }

    private function messages()
    {
        return [
            'backstamp_code.required' => __('controller.validation.backstamp_code.required'),
            'backstamp_code.unique' => __('controller.validation.backstamp_code.unique'),
            'backstamp_code.max' => __('controller.validation.backstamp_code.max'),
            'name.max' => __('controller.validation.name.max'),
            'customer_id.exists' => __('controller.validation.customer_id.exists'),
            'status_id.exists' => __('controller.validation.status_id.exists'),
            'in_glaze.boolean' => __('controller.validation.in_glaze.boolean'),
            'on_glaze.boolean' => __('controller.validation.on_glaze.boolean'),
            'under_glaze.boolean' => __('controller.validation.under_glaze.boolean'),
            'air_dry.boolean' => __('controller.validation.air_dry.boolean'),
            'organic.boolean' => __('controller.validation.organic.boolean'),
            'approval_date.date' => __('controller.validation.approval_date.date'),
        ];
    }

    public function storeBackstamp(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());
        $data['updated_by'] = auth()->id();
        $this->handleNewSelectableData($data);
        $backstamp = Backstamp::create($data);
        
        // จัดการรูปภาพ
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $fileName = $image->getClientOriginalName();
                $filePath = $image->store('backstamps', 'public');

                $backstamp->images()->create([
                    'file_name' => $fileName,
                    'file_path' => $filePath
                ]);
            }
        }
        
        return response()->json([
            'status'    => 'success',
            'message'   => __('controller.backstamp.created'),
            'backstamp' => $backstamp->load('images')
        ], 201);
    }

    public function updateBackstamp(Request $request, Backstamp $backstamp)
    {
        $data = $request->validate($this->rules($backstamp->id), $this->messages());
        $data['updated_by'] = auth()->id();
        $this->handleNewSelectableData($data);
        $backstamp->update($data);
        
        // จัดการรูปภาพใหม่
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $fileName = $image->getClientOriginalName();
                $filePath = $image->store('backstamps', 'public');

                $backstamp->images()->create([
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
            'status'    => 'success',
            'message'   => __('controller.backstamp.updated'),
            'backstamp' => $backstamp->load('images'),
        ], 200);
    }

    public function destroyBackstamp(Backstamp $backstamp)
    {
        $backstamp->delete();
        return response()->json([
            'status' => 'success',
            'message' => __('controller.backstamp.deleted')
        ]);
    }
}
