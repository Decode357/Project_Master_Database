<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Effect, Color};

class EffectController extends Controller
{
    public function effectindex()
    {
        $effects = Effect::with('colors')->latest()->paginate(10);
        $colors = Color::with('customer')->get();

        return view('effect', compact('effects', 'colors'));
    }

    private function rules($id = null)
    {
        return [
            'effect_code' => [
                'required', 'string', 'max:255',
                Rule::unique('effects', 'effect_code')->ignore($id),
            ],
            'effect_name' => [
                'required', 'string', 'max:255',
                Rule::unique('effects', 'effect_name')->ignore($id),
            ],
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
        return redirect()->route('effect.index')->with('success', 'Effect deleted successfully.',200);
    }
}
