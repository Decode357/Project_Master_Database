<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{
    Glaze, Status, Effect, 
    GlazeInside, GlazeOuter, Image
};

class GlazeController extends Controller
{
    public function glazeindex(Request $request)
    {        
        $relations = [
            'status', 'updater', 'effect.colors','effect',        
            'glazeInside.colors', 'glazeOuter.colors', 'images'
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

        $query = Glaze::with($relations);
        // เพิ่ม search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('glaze_code', 'LIKE', "%{$search}%")
                ->orWhere('approval_date', 'LIKE', "%{$search}%")
                ->orWhereHas('effect', function($q) use ($search) {
                    $q->where('effect_code', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('glazeOuter', function($q) use ($search) {
                    $q->where('glaze_outer_code', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('glazeInside', function($q) use ($search) {
                    $q->where('glaze_inside_code', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('status', function($q) use ($search) {
                    $q->where('status', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('updater', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $glazes = $query->latest()->paginate($perPage)->appends($request->query());

        $data = [
            'statuses'     => Status::all(),
            'effects'      => Effect::all(),
            'glazeOuters'  => GlazeOuter::all(),
            'glazeInsides' => GlazeInside::all(),
        ];
        $permissions = $this->getUserPermissions();
        return view('glaze', array_merge($data, compact('glazes'), $permissions));
    }

    private function rules($id = null)
    {
        return [
            'glaze_code'      => [
                'required', 'string', 'max:255',
                Rule::unique('glazes', 'glaze_code')->ignore($id),
            ],
            'status_id'       => 'nullable|exists:statuses,id',
            'fire_temp'       => 'nullable|integer',
            'approval_date'   => 'nullable|date',
            'glaze_inside_id' => 'nullable|exists:glaze_insides,id',
            'glaze_outer_id'  => 'nullable|exists:glaze_outers,id',
            'effect_id'       => 'nullable|exists:effects,id',
        ];
    }

    public function storeGlaze(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['updated_by'] = auth()->id();

        $glaze = Glaze::create($data);
        
        return response()->json([
            'status'  => 'success',
            'message' => 'Glaze created successfully!',
            'glaze'   => $glaze
        ], 201);
    }

    public function updateGlaze(Request $request, Glaze $glaze)
    {
        $data = $request->validate($this->rules($glaze->id));
        $data['updated_by'] = auth()->id();

        $glaze->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Glaze updated successfully!',
            'glaze'   => $glaze
        ], 200);
    }

    public function destroyGlaze(Glaze $glaze)
    {
        $glaze->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Shape deleted successfully.'
        ]);    
    }
}
