<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{
    Backstamp, Status, Image,
    Requestor, Customer
};

class BackstampController extends Controller
{
    public function backstampindex()
    {
        $relations = [
            'requestor', 'customer', 'status', 'image', 'updater'
        ];
        
        $backstamps = Backstamp::with($relations)->latest()->paginate(10);

        $data = [
            'statuses'   => Status::all(),
            'requestors' => Requestor::all(),
            'customers'  => Customer::all(),
            'images'     => Image::all(),
        ];

        return view('backstamp', array_merge($data, compact('backstamps')));
    }

    private function rules($id = null)
    {
        return [
            'backstamp_code' => [
                'required', 'string', 'max:255',
                Rule::unique('backstamps', 'backstamp_code')->ignore($id),
            ],
            'name'           => 'required|string|max:255',
            'requestor_id'   => 'nullable|exists:requestors,id',
            'customer_id'    => 'nullable|exists:customers,id',
            'status_id'      => 'nullable|exists:statuses,id',
            'duration'       => 'nullable|integer',
            'in_glaze'       => 'nullable|boolean',
            'on_glaze'       => 'nullable|boolean',
            'under_glaze'    => 'nullable|boolean',
            'air_dry'        => 'nullable|boolean',
            'approval_date'  => 'nullable|date',
            'image_id'       => 'nullable|exists:images,id',
        ];
    }

    public function storeBackstamp(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['updated_by'] = auth()->id();

        $backstamp = Backstamp::create($data);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Backstamp created successfully!',
            'backstamp' => $backstamp
        ], 201);
    }

    public function updateBackstamp(Request $request, Backstamp $backstamp)
    {
        $data = $request->validate($this->rules($backstamp->id));
        $data['updated_by'] = auth()->id();

        $backstamp->update($data);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Backstamp updated successfully.',
            'backstamp' => $backstamp,
        ],200);
    }

    public function destroyBackstamp(Backstamp $backstamp)
    {
        $backstamp->delete();
        return redirect()->route('backstamp.index')->with('success', 'Backstamp deleted successfully.',200);
    }
}
