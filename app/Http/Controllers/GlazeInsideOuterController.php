<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{GlazeInside,GlazeOuter,Color};

class GlazeInsideOuterController extends Controller
{
public function index()
{
    $glaze_insides = GlazeInside::with('colors')
        ->latest()
        ->paginate(10, ['*'], 'inside_page');   

    $glaze_outers = GlazeOuter::with('colors')
        ->latest()
        ->paginate(10, ['*'], 'outer_page'); 
    
    $colors = Color::all();

    return view('glazeInsideOuter', compact('glaze_insides', 'glaze_outers', 'colors'));
}


    private function rules($type = 'outer', $id = null)
    {
        // ตรวจชนิดว่าเป็น outer หรือ inside
        $field = $type === 'outer' ? 'glaze_outer_code' : 'glaze_inside_code';
        $table = $type === 'outer' ? 'glaze_outers' : 'glaze_insides';

        return [
            $field => [
                'required',
                'string',
                'max:255',
                "unique:{$table},{$field}," . ($id ?? 'NULL') . ",id",
            ],
            'colors'   => 'nullable|array',
            'colors.*' => 'exists:colors,id',
        ];
    }

    public function destroyGlazeOuter(GlazeOuter $glazeOuter)
    {
        $glazeOuter->delete();
        return redirect()->route('glaze.inside.outer.index')->with('success', 'Glaze Outer deleted successfully.',200);
    }
    public function destroyGlazeInside(GlazeInside $glazeInside)
    {
        $glazeInside->delete();
        return redirect()->route('glaze.inside.outer.index')->with('success', 'Glaze Inside deleted successfully.',200);
    }

    public function storeGlazeInside(Request $request)
    {
        $validated = $request->validate($this->rules('inside'));

        $glazeInside = GlazeInside::create([
            'glaze_inside_code' => $validated['glaze_inside_code'],
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        // Sync colors if provided
        if (isset($validated['colors'])) {
            $glazeInside->colors()->sync($validated['colors']);
        }

        return response()->json(['message' => 'Glaze Inside created successfully'], 201);
    }

    public function storeGlazeOuter(Request $request)
    {
        $validated = $request->validate($this->rules('outer'));

        $glazeOuter = GlazeOuter::create([
            'glaze_outer_code' => $validated['glaze_outer_code'],
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        // Sync colors if provided
        if (isset($validated['colors'])) {
            $glazeOuter->colors()->sync($validated['colors']);
        }

        return response()->json(['message' => 'Glaze Outer created successfully'], 201);
    }
    
    public function updateGlazeInside(Request $request, GlazeInside $glazeInside)
    {
        $validated = $request->validate($this->rules('inside', $glazeInside->id));

        $glazeInside->update([
            'glaze_inside_code' => $validated['glaze_inside_code'],
            'updated_by' => auth()->id(),
        ]);

        // Sync colors if provided
        if (isset($validated['colors'])) {
            $glazeInside->colors()->sync($validated['colors']);
        } else {
            $glazeInside->colors()->detach();
        }

        return response()->json(['message' => 'Glaze Inside updated successfully'], 200);
    }

    public function updateGlazeOuter(Request $request, GlazeOuter $glazeOuter)
    {
        $validated = $request->validate($this->rules('outer', $glazeOuter->id));

        $glazeOuter->update([
            'glaze_outer_code' => $validated['glaze_outer_code'],
            'updated_by' => auth()->id(),
        ]);

        // Sync colors if provided
        if (isset($validated['colors'])) {
            $glazeOuter->colors()->sync($validated['colors']);
        } else {
            $glazeOuter->colors()->detach();
        }

        return response()->json(['message' => 'Glaze Outer updated successfully'], 200);
    }
}
