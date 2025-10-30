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

    private function rules($id = null)
    {
        return [
            'backstamp_code' => [
                'required', 'string', 'max:255',
                Rule::unique('backstamps', 'backstamp_code')->ignore($id),
            ],
            'name'           => 'nullable|string|max:255',
            'requestor_id'   => 'nullable|exists:requestors,id',
            'customer_id'    => 'nullable|exists:customers,id',
            'status_id'      => 'nullable|exists:statuses,id',
            'in_glaze'       => 'nullable|boolean',
            'on_glaze'       => 'nullable|boolean',
            'under_glaze'    => 'nullable|boolean',
            'air_dry'        => 'nullable|boolean',
            'organic'         => 'nullable|boolean',
            'approval_date'  => 'nullable|date',
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
        return response()->json([
            'status' => 'success',
            'message' => 'Backstamp deleted successfully.'
        ]);
    }
}
