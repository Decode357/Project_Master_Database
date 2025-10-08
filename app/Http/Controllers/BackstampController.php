<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use App\Models\{
    Backstamp, Status, Image,
    Requestor, Customer
};
 

class BackstampController extends Controller
{
    public function storeBackstamp(Request $request)
    {
        $data = $request->validate([
            'backstamp_code'      => 'required|string|max:255|unique:backstamps,backstamp_code',
            'name'                => 'required|string|max:255',
            'requestor_id'        => 'nullable|exists:requestors,id',
            'customer_id'         => 'nullable|exists:customers,id',
            'status_id'           => 'nullable|exists:statuses,id',
            'duration'            => 'nullable|integer',
            'in_glaze'           => 'nullable|boolean',
            'on_glaze'          => 'nullable|boolean',
            'under_glaze'       => 'nullable|boolean',
            'air_dry'          => 'nullable|boolean',
            'approval_date'    => 'nullable|date',
            'image_id'           => 'nullable|exists:images,id',
        ]);

        $backstamp = Backstamp::create([
            'backstamp_code'      => $data['backstamp_code'],
            'name'                => $data['name'],
            'requestor_id'        => $data['requestor_id'] ?? null,
            'customer_id'         => $data['customer_id'] ?? null,
            'status_id'           => $data['status_id'] ?? null,
            'duration'            => $data['duration'] ?? null,
            'in_glaze'           => $data['in_glaze'] ?? false,
            'on_glaze'          => $data['on_glaze'] ?? false,
            'under_glaze'       => $data['under_glaze'] ?? false,
            'air_dry'          => $data['air_dry'] ?? false,
            'approval_date'    => $data['approval_date'] ?? null,
            'image_id'           => $data['image_id'] ?? null,
            'updated_by'         => auth()->id(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Backstamp created successfully!',
            'backstamp'   => $backstamp
        ], 200);
    }
    public function backstampindex() {
        $backstamps = Backstamp::with(['requestor', 'customer', 'status', 
        'image', 'updater'])->orderBy('id', 'desc')->paginate(10);
        
        $statuses = Status::all();
        $requestors = Requestor::all();
        $customers = Customer::all();
        $images = Image::all();

        return view('backstamp', compact('backstamps', 'statuses', 'requestors', 'customers', 'images'));
    }
    
    public function destroyBackstamp(Backstamp $backstamp)
    {
        $backstamp->delete();

        return redirect()->route('backstamp.index')->with('success', 'Backstamp deleted successfully.');
    }
}
