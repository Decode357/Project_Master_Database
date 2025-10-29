<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{
    Pattern, Status, Designer, 
    Requestor, Customer, Image
};

class PatternController extends Controller
{
    public function patternindex(Request $request)
    {
        $relations = [
            'requestor', 'customer', 'status', 
            'designer', 'updater', 'images'
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
        $query = Pattern::with($relations);

        // เพิ่ม search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('pattern_code', 'LIKE', "%{$search}%")
                ->orWhere('approval_date', 'LIKE', "%{$search}%")
                ->orWhereHas('designer', function($q) use ($search) {
                    $q->where('designer_name', 'LIKE', "%{$search}%");
                })
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


        $patterns = $query->latest()->paginate($perPage)->appends($request->query());
        $data = [
            'statuses'   => Status::all(),
            'designers'  => Designer::all(),
            'requestors' => Requestor::all(),
            'customers'  => Customer::all(),
        ];
        $permissions = $this->getUserPermissions();
        return view('pattern', array_merge($data, compact('patterns', 'perPage', 'search'), $permissions));
    }

    private function rules($id = null)
    {
        return [
            'pattern_code'   => [
                'required', 'string', 'max:255',
                Rule::unique('patterns', 'pattern_code')->ignore($id),
            ],
            'pattern_name'   => 'nullable|string|max:255',
            'requestor_id'   => 'nullable|exists:requestors,id',
            'customer_id'    => 'nullable|exists:customers,id',
            'status_id'      => 'nullable|exists:statuses,id',
            'designer_id'    => 'nullable|exists:designers,id',
            'in_glaze'       => 'nullable|boolean',
            'on_glaze'       => 'nullable|boolean',
            'under_glaze'    => 'nullable|boolean',
            'approval_date'  => 'nullable|date',
        ];
    }

    public function storePattern(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['updated_by'] = auth()->id();

        $pattern = Pattern::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pattern created successfully!',
            'pattern' => $pattern
        ], 201);
    }

    public function updatePattern(Request $request, Pattern $pattern)
    {
        $data = $request->validate($this->rules($pattern->id));
        $data['updated_by'] = auth()->id();

        $pattern->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pattern updated successfully!',
            'pattern' => $pattern
        ], 200);
    }

    public function destroyPattern(Pattern $pattern)
    {
        $pattern->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.'
        ]);
    }
}
