<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use App\Models\{
    Color, Glaze, Effect, 
    GlazeInside, GlazeOuter, Customer
};

class ColorController extends Controller
{
    public function storeColor(Request $request)
    {
        $data = $request->validate([
            'color_code' => [
                'required',
                'string',
                'max:7',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', // ✅ ตรวจสอบรูปแบบ HEX เท่านั้น
            ],
            'color_name' => 'required|string|max:255',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $color = Color::create([
            'color_code'  => $data['color_code'],
            'color_name'  => $data['color_name'],
            'customer_id' => $data['customer_id'] ?? null,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Color created successfully!',
            'color'   => $color
        ], 200);
    }
    public function colorindex() {
        $colors = Color::orderBy('id', 'desc')->paginate(10);

        $customers = Customer::all();

        return view('color',compact('colors', 'customers'));
    }
    
    public function destroyColor(Color $color)
    {
        $color->delete();

        return redirect()->route('color.index')->with('success', 'Color deleted successfully.');
    }
}
