<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ShapeCollection};

class ShapeCollectionController extends Controller
{
    public function shapecollectionindex(Request $request)
    {
        // รับค่า perPage จาก request หรือใช้ default 10
        $perPage = $request->get('per_page', 10);
        // จำกัดค่า perPage ที่อนุญาต
        $allowedPerPage = [5, 10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        // รับค่า search
        $search = $request->get('search');
        $query = ShapeCollection::query();
        // เพิ่ม search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('collection_code', 'LIKE', "%{$search}%")
                ->orWhere('collection_name', 'LIKE', "%{$search}%");
            });
        }
        $shapeCollections = $query->latest()->paginate($perPage)->appends($request->query());


        $permissions = $this->getUserPermissions();

        return view('shapeCollection', compact('shapeCollections', 'perPage', 'search'), $permissions);
    }

    private function rules($id = null)
    {
        return [
            'collection_code' => [
                'required', 'string', 'max:255',
                Rule::unique('shape_collections', 'collection_code')->ignore($id),
            ],
            'collection_name' => [
                'required', 'string', 'max:255',
                Rule::unique('shape_collections', 'collection_name')->ignore($id),
            ],
        ];
    }

    public function storeShapeCollection(Request $request)
    { 
        $data = $request->validate($this->rules());

        $shapeCollection = ShapeCollection::create([
            'collection_code' => $data['collection_code'],
            'collection_name' => $data['collection_name'],
        ]);
        return response()->json([
            'status'  => 'success',
            'message' => 'Shape Collection created successfully!',
            'shapeCollection'  => $shapeCollection
        ], 201);
    }

    public function updateShapeCollection(Request $request, ShapeCollection $shapeCollection)
    {
        $data = $request->validate($this->rules($shapeCollection->id));

        $shapeCollection->update([
            'collection_code' => $data['collection_code'],
            'collection_name' => $data['collection_name'],
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Shape Collection updated successfully!',
            'shapeCollection'  => $shapeCollection
        ], 200);
    }

    public function destroyShapeCollection(ShapeCollection $shapeCollection)
    {
        $shapeCollection->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Shape Collection deleted successfully.'
        ]);
    }
}
