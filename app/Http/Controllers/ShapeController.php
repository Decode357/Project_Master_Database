<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use App\Models\{
    Shape, ShapeType, Status, 
    ShapeCollection, Customer, ItemGroup, 
    Process, Designer, Requestor, 
    Image};

class ShapeController extends Controller
{
    public function shapeindex()
    {
        $shapes = Shape::with(['shapeType', 'status', 'shapeCollection', 'customer',
        'itemGroup', 'process', 'designer', 'requestor', 'image', 'updater'])
        ->orderBy('id', 'desc')->paginate(10);
        $shapeTypes = ShapeType::all();
        $statuses = Status::all();
        $shapeCollections = ShapeCollection::all();
        $customers = Customer::all();
        $itemGroups = ItemGroup::all();
        $processes = Process::all();
        $designers = Designer::all();
        $requestors = Requestor::all();

        return view('shape', compact('shapes', 'shapeTypes', 'statuses', 'shapeCollections',
        'customers', 'itemGroups', 'processes', 'designers', 'requestors'));
    }


    public function storeShape(Request $request)
    {
        $data = $request->validate([
            'item_code'      => 'required|string|max:255|unique:shapes,item_code',
            'item_description_thai' => 'nullable|string|max:255',
            'item_description_eng' => 'nullable|string|max:255',
            'shape_type_id'   => 'nullable|exists:shape_types,id',
            'status_id'       => 'nullable|exists:statuses,id',
            'process_id'      => 'nullable|exists:processes,id',
            'item_group_id'   => 'nullable|exists:item_groups,id',
            'requestor_id'    => 'nullable|exists:requestors,id',
            'customer_id'     => 'nullable|exists:customers,id',
            'designer_id'     => 'nullable|exists:designers,id',
            'shape_collection_id' => 'nullable|exists:shape_collections,id',
            'image_id'        => 'nullable|exists:images,id',
            'volume'         => 'nullable|numeric',
            'weight'         => 'nullable|numeric',
            'long_diameter'  => 'nullable|numeric',
            'short_diameter' => 'nullable|numeric',
            'height_long'    => 'nullable|numeric',
            'height_short'   => 'nullable|numeric',
            'body'           => 'nullable|numeric',
            'approval_date' => 'nullable|date',
        ]);

        $shape = Shape::create([
            'item_code'      => $data['item_code'],
            'item_description_thai' => $data['item_description_thai'] ?? null,
            'item_description_eng' => $data['item_description_eng'] ?? null,
            'shape_type_id'   => $data['shape_type_id'],
            'status_id'       => $data['status_id'],
            'process_id'      => $data['process_id'],
            'item_group_id'   => $data['item_group_id'] ?? null,
            'requestor_id'    => $data['requestor_id'] ?? null,
            'customer_id'     => $data['customer_id'] ?? null,
            'designer_id'     => $data['designer_id'] ?? null,
            'shape_collection_id' => $data['shape_collection_id'] ?? null,
            'image_id'        => $data['image_id'] ?? null,
            'updated_by'      => auth()->id(),
            'volume'         => $data['volume'] ?? null,
            'weight'         => $data['weight'] ?? null,
            'long_diameter'  => $data['long_diameter'] ?? null,
            'short_diameter' => $data['short_diameter'] ?? null,
            'height_long'    => $data['height_long'] ?? null,
            'height_short'   => $data['height_short'] ?? null,
            'body'           => $data['body'] ?? null,
            'approval_date' => $data['approval_date'] ?? null,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Shape created successfully!',
            'shape'   => $shape
        ], 200);
    }

    public function destroyShape(Shape $shape)
    {
        $shape->delete();

        return redirect()->route('shape.index')->with('success', 'Shape deleted successfully.');
    }

    public function updateShape(Request $request, Shape $shape)
    {
        $data = $request->validate([
            'item_code'      => 'required|string|max:255|unique:shapes,item_code,' . $shape->id,
            'item_description_thai' => 'nullable|string|max:255',
            'item_description_eng' => 'nullable|string|max:255',
            'shape_type_id'   => 'nullable|exists:shape_types,id',
            'status_id'       => 'nullable|exists:statuses,id',
            'process_id'      => 'nullable|exists:processes,id',
            'item_group_id'   => 'nullable|exists:item_groups,id',
            'requestor_id'    => 'nullable|exists:requestors,id',
            'customer_id'     => 'nullable|exists:customers,id',
            'designer_id'     => 'nullable|exists:designers,id',
            'shape_collection_id' => 'nullable|exists:shape_collections,id',
            'image_id'        => 'nullable|exists:images,id',
            'volume'         => 'nullable|numeric',
            'weight'         => 'nullable|numeric',
            'long_diameter'  => 'nullable|numeric',
            'short_diameter' => 'nullable|numeric',
            'height_long'    => 'nullable|numeric',
            'height_short'   => 'nullable|numeric',
            'body'           => 'nullable|numeric',
            'approval_date'  => 'nullable|date',
        ]);

        $shape->update([
            'item_code'      => $data['item_code'],
            'item_description_thai' => $data['item_description_thai'] ?? null,
            'item_description_eng' => $data['item_description_eng'] ?? null,
            'shape_type_id'   => $data['shape_type_id'],
            'status_id'       => $data['status_id'],
            'process_id'      => $data['process_id'],
            'item_group_id'   => $data['item_group_id'] ?? null,
            'requestor_id'    => $data['requestor_id'] ?? null,
            'customer_id'     => $data['customer_id'] ?? null,
            'designer_id'     => $data['designer_id'] ?? null,
            'shape_collection_id' => $data['shape_collection_id'] ?? null,
            'image_id'        => $data['image_id'] ?? null,
            'updated_by'      => auth()->id(),
            'volume'         => $data['volume'] ?? null,
            'weight'         => $data['weight'] ?? null,
            'long_diameter'  => $data['long_diameter'] ?? null,
            'short_diameter' => $data['short_diameter'] ?? null,
            'height_long'    => $data['height_long'] ?? null,
            'height_short'   => $data['height_short'] ?? null,
            'body'           => $data['body'] ?? null,
            'approval_date'  => $data['approval_date'] ?? null,
        ]);

        $shape->save();
        
        return response()->json([
            'status'  => 'success',
            'message' => 'Shape updated successfully!',
            'shape'   => $shape
        ], 200);

    }


}
