<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{GlazeInside,GlazeOuter,Color};

class GlazeInsideOuterController extends Controller
{
    public function index(Request $request)
    {
        // รับค่า pagination parameters
        $insidePerPage = $request->get('inside_per_page', 10);
        $outerPerPage = $request->get('outer_per_page', 10);
        
        // จำกัดค่า perPage ที่อนุญาต
        $allowedPerPage = [5, 10, 25, 50, 100];
        if (!in_array($insidePerPage, $allowedPerPage)) $insidePerPage = 10;
        if (!in_array($outerPerPage, $allowedPerPage)) $outerPerPage = 10;
        
        // รับค่า search parameters
        $insideSearch = $request->get('inside_search');
        $outerSearch = $request->get('outer_search');

        // Query สำหรับ Glaze Inside
        $insideQuery = GlazeInside::with('colors');
        if ($insideSearch) {
            $insideQuery->where('glaze_inside_code', 'LIKE', "%{$insideSearch}%");
        }
        
        $glaze_insides = $insideQuery->latest()
            ->paginate($insidePerPage, ['*'], 'inside_page')
            ->appends($request->except('inside_page'));

        // Query สำหรับ Glaze Outer  
        $outerQuery = GlazeOuter::with('colors');
        if ($outerSearch) {
            $outerQuery->where('glaze_outer_code', 'LIKE', "%{$outerSearch}%");
        }
        
        $glaze_outers = $outerQuery->latest()
            ->paginate($outerPerPage, ['*'], 'outer_page')
            ->appends($request->except('outer_page'));
        
        $colors = Color::all();

        return view('glazeInsideOuter', compact(
            'glaze_insides', 'glaze_outers', 'colors',
            'insidePerPage', 'outerPerPage', 'insideSearch', 'outerSearch'
        ));
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
