<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use App\Models\{
    Effect, Color, Customer
};

class EffectController extends Controller
{
    public function storeEffect(Request $request)
    { 
        $data = $request->validate([
            'effect_code' => 'required|string|max:255|unique:effects,effect_code',
            'effect_name' => 'required|string|max:255|unique:effects,effect_name',
            'colors'      => 'nullable|array',
            'colors.*'    => 'exists:colors,id',
        ]);

        $effect = Effect::create([
            'effect_code' => $data['effect_code'],
            'effect_name' => $data['effect_name'],
        ]);
       
        // ตรวจสอบและบันทึก colors หากมีการเลือก
        if (!empty($data['colors']) && is_array($data['colors'])) {
            $effect->colors()->attach($data['colors']);
        }

        $effect->load('colors.customer');

        return response()->json([
            'status'  => 'success',
            'message' => 'Effect created successfully!',
            'effect'  => $effect
        ], 200);
    }

    public function effectindex()
    {
        // Eager load colors เพื่อลด query และ join pivot table
        $effects = Effect::with('colors')
                        ->orderBy('id', 'asc')
                        ->paginate(10);
        $colors = Color::with('customer')->get(); // โหลด customer มาด้วย
        return view('effect', compact('effects', 'colors'));
    }

    public function destroyEffect(Effect $effect)
    {
        $effect->delete();

        return redirect()->route('effect.index')->with('success', 'Effect deleted successfully.');
    }
}
