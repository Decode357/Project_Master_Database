<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Color, Customer};

class ColorController extends Controller
{
    public function colorindex()
    {
        $colors = Color::latest()->paginate(10);
        $customers = Customer::all();

        return view('color', compact('colors', 'customers'));
    }

    private function rules()
    {
        return [
            'color_code' => [
                'required', 'string', 'max:7',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            ],
            'color_name'  => 'required|string|max:255',
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
        return redirect()->route('color.index')->with('success', 'Color deleted successfully.',200);
    }
}
