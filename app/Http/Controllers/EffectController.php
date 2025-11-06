<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Effect, Color};

class EffectController extends Controller
{    public function effectindex(Request $request)
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
        $query = Effect::with('colors');
        // เพิ่ม search functionality
        if ($search) {
            $query->where('effect_code', 'LIKE', "%{$search}%")
            ->orWhereHas('colors', function($q) use ($search) {
                $q->where('color_code', 'LIKE', "%{$search}%");
            });
        }
        $effects = $query->latest()->paginate($perPage)->appends($request->query());

        $colors = Color::with('customer')->get();

        $permissions = $this->getUserPermissions();

        return view('effect', compact('effects', 'colors', 'perPage', 'search'), $permissions);
    }

    private function rules($id = null)
    {
        return [
            'effect_code' => [
                'required', 'string', 'max:255',
                Rule::unique('effects', 'effect_code')->ignore($id),
            ],
            'effect_name' => 'nullable|string|max:255',
            'colors'      => 'nullable|array',
            'colors.*'    => 'exists:colors,id',
        ];
    }

    public function storeEffect(Request $request)
    { 
        $data = $request->validate($this->rules());

        $effect = Effect::create([
            'effect_code' => $data['effect_code'],
            'effect_name' => $data['effect_name'],
        ]);

        if (!empty($data['colors']) && is_array($data['colors'])) {
            $effect->colors()->attach($data['colors']);
        }

        $effect->load('colors.customer');

        return response()->json([
            'status'  => 'success',
            'message' => 'Effect created successfully!',
            'effect'  => $effect
        ], 201);
    }

    public function updateEffect(Request $request, Effect $effect)
    {
        $data = $request->validate($this->rules($effect->id));

        $effect->update([
            'effect_code' => $data['effect_code'],
            'effect_name' => $data['effect_name'],
        ]);

        if (isset($data['colors']) && is_array($data['colors'])) {
            $effect->colors()->sync($data['colors']);
        } else {
            $effect->colors()->detach();
        }

        $effect->load('colors.customer');

        return response()->json([
            'status'  => 'success',
            'message' => 'Effect updated successfully!',
            'effect'  => $effect
        ], 200);
    }

    public function destroyEffect(Effect $effect)
    {
        $effect->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Effect deleted successfully.'
        ]);
    }

}
