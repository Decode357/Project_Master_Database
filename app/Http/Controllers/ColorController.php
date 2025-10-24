<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Color, Customer};

class ColorController extends Controller
{
    public function colorindex(Request $request)
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
        $query = Color::with('customer');
        // เพิ่ม search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('color_code', 'LIKE', "%{$search}%")
                ->orWhere('color_name', 'LIKE', "%{$search}%")
                ->orWhereHas('customer', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $colors = $query->latest()->paginate($perPage)->appends($request->query());

        $customers = Customer::all();
        $permissions = $this->getUserPermissions();
        return view('color', compact('colors', 'customers', 'perPage', 'search'), $permissions);
    }

    private function rules()
    {
        return [
            'color_code' => 'required|string|max:255',
            'color_name'  => 'nullable|string|max:255',
            'customer_id' => 'nullable|exists:customers,id',
        ];
    }

    public function storeColor(Request $request)
    {
        $data = $request->validate($this->rules());

        $color = Color::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Color created successfully!',
            'color'   => $color
        ], 201);
    }

    public function updateColor(Request $request, Color $color)
    {
        $data = $request->validate($this->rules());

        $color->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Color updated successfully!',
            'color' => $color
        ], 200);
    }
    
    public function destroyColor(Color $color)
    {
        $color->delete();
                return response()->json([
            'status' => 'success',
            'message' => 'Color deleted successfully.'
        ]);
    }
}
