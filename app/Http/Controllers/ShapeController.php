<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Shape, ShapeType, Status, ShapeCollection, Customer,
    ItemGroup, Process, Designer, Requestor, Image
};

class ShapeController extends Controller
{
    public function shapeindex()
    {
        $relations = [
            'shapeType', 'status', 'shapeCollection', 'customer',
            'itemGroup', 'process', 'designer', 'requestor', 'updater', 'image'
        ];

        $shapes = Shape::with($relations)->latest()->paginate(10);

        $data = [
            'shapeTypes' => ShapeType::all(),
            'statuses' => Status::all(),
            'shapeCollections' => ShapeCollection::all(),
            'customers' => Customer::all(),
            'itemGroups' => ItemGroup::all(),
            'processes' => Process::all(),
            'designers' => Designer::all(),
            'requestors' => Requestor::all(),
            'images' => Image::all(),
        ];

        return view('shape', array_merge($data, compact('shapes')));
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
            'process_id'    => 'nullable|exists:processes,id',
            'item_group_id' => 'nullable|exists:item_groups,id',
            'requestor_id'  => 'nullable|exists:requestors,id',
            'customer_id'   => 'nullable|exists:customers,id',
            'designer_id'   => 'nullable|exists:designers,id',
            'shape_collection_id' => 'nullable|exists:shape_collections,id',
            'image_id'      => 'nullable|exists:images,id',
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

        $shape = Shape::create($data);

        return response()->json([
            'status' => 'success', 
            'message' => 'Shape created successfully!', 
            'shape' => $shape
        ], 201);
    }

    public function updateShape(Request $request, Shape $shape)
    {
        $data = $request->validate($this->rules($shape->id));
        $data['updated_by'] = auth()->id();

        $shape->update($data);

        return response()->json([
            'status' => 'success', 
            'message' => 'Shape updated successfully!', 
            'shape' => $shape
        ],200);
    }

    public function destroyShape(Shape $shape)
    {
        $shape->delete();
        return redirect()->route('shape.index')
            ->with('success', 'Shape deleted successfully.',200);
    }
}
