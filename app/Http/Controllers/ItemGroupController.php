<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ItemGroup;
use Illuminate\Support\Str;

class ItemGroupController extends Controller
{
    public function itemGroupindex(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $allowedPerPage = [5, 10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $search = $request->get('search');
        $query = ItemGroup::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('item_group_name', 'LIKE', "%{$search}%");
            });
        }
        
        $itemGroups = $query->latest()->paginate($perPage)->appends($request->query());
        $permissions = $this->getUserPermissions();

        return view('itemGroup', compact('itemGroups', 'perPage', 'search'), $permissions);
    }

    private function rules($id = null)
    {
        return [
            'item_group_name' => [
                'required', 'string', 'max:255',
                Rule::unique('item_groups', 'item_group_name')->ignore($id),
            ],
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ];
    }

    private function messages()
    {
        return [
            'item_group_name.required' => __('controller.validation.item_group_name.required'),
            'item_group_name.unique' => __('controller.validation.item_group_name.unique'),
            'item_group_name.max' => __('controller.validation.item_group_name.max'),
            'image.image' => __('controller.validation.image.image'),
            'image.mimes' => __('controller.validation.image.mimes'),
            'image.max' => __('controller.validation.image.max')
        ];
    }

    public function storeItemGroup(Request $request)
    { 
        $data = $request->validate($this->rules(), $this->messages());

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $this->handleImageUpload($request->file('image'), $data['item_group_name']);
        }

        $itemGroup = ItemGroup::create([
            'item_group_name' => $data['item_group_name'],
            'image' => $imageName
        ]);
        
        return response()->json([
            'status'  => 'success',
            'message' => __('controller.item_group.created'),
            'itemGroup'  => $itemGroup->load([]) // รีเฟรช เพื่อให้ได้ imageUrl
        ], 201);
    }

    public function updateItemGroup(Request $request, ItemGroup $itemGroup)
    {
        $data = $request->validate($this->rules($itemGroup->id), $this->messages());

        $imageName = $itemGroup->image; // เก็บชื่อเดิมไว้ก่อน

        // ถ้ามีรูปใหม่
        if ($request->hasFile('image')) {
            // ลบรูปเก่า
            $itemGroup->deleteImage();
            // อัพโหลดรูปใหม่
            $imageName = $this->handleImageUpload($request->file('image'), $data['item_group_name']);
        }
        // ถ้าต้องการลบรูป (มี checkbox delete_image)
        elseif ($request->has('delete_image') && $request->delete_image == '1') {
            $itemGroup->deleteImage();
            $imageName = null;
        }

        $itemGroup->update([
            'item_group_name' => $data['item_group_name'],
            'image' => $imageName
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => __('controller.item_group.updated'),
            'itemGroup'  => $itemGroup->fresh() // รีเฟรชข้อมูล
        ], 200);
    }

    public function destroyItemGroup(ItemGroup $itemGroup)
    {
        // ลบรูปภาพก่อน
        $itemGroup->deleteImage();
        
        // ลบข้อมูล
        $itemGroup->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => __('controller.item_group.deleted')
        ]);
    }

    /**
     * จัดการอัพโหลดรูปภาพ
     */
private function handleImageUpload($file, $itemGroupName)
{
    $extension = $file->getClientOriginalExtension();
    $path = public_path('images/itemGroup');

    // 1) ล้างอักขระแปลก ๆ แต่ยังอนุญาต ภาษาไทย + อังกฤษ + ตัวเลข + _ -
    $cleanName = preg_replace('/[^ก-ฮ๐-๙a-zA-Z0-9_\-]/u', '_', $itemGroupName);

    // 2) ตัดช่องว่างซ้ำ ๆ 
    $cleanName = preg_replace('/_+/', '_', $cleanName);

    // 3) ถ้าชื่อเป็นภาษาไทย → ใช้ชื่อไทย
    //    ถ้าไม่มีไทยเลย → fallback ไปใช้ slug เดิม
    if (!preg_match('/[ก-ฮ]/u', $cleanName)) {
        $cleanName = Str::slug($itemGroupName, '_');
    }

    // 4) ประกอบชื่อไฟล์
    $fileName = $cleanName . '.' . $extension;

    // 5) เช็คไฟล์ซ้ำ
    $counter = 1;
    while (file_exists($path . '/' . $fileName)) {
        $fileName = $cleanName . '_' . $counter . '.' . $extension;
        $counter++;
    }

    // 6) ย้ายไฟล์
    $file->move($path, $fileName);

    return $fileName;
}

}
