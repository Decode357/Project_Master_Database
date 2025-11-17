<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            $insideQuery->where('glaze_inside_code', 'LIKE', "%{$insideSearch}%")
            ->orWhereHas('colors', function($q) use ($insideSearch) {
                $q->where('color_code', 'LIKE', "%{$insideSearch}%");
            });
        }
        
        $glaze_insides = $insideQuery->latest()
            ->paginate($insidePerPage, ['*'], 'inside_page')
            ->appends($request->except('inside_page'));

        // Query สำหรับ Glaze Outer  
        $outerQuery = GlazeOuter::with('colors');
        if ($outerSearch) {
            $outerQuery->where('glaze_outer_code', 'LIKE', "%{$outerSearch}%")
            ->orWhereHas('colors', function($q) use ($outerSearch) {
                $q->where('color_code', 'LIKE', "%{$outerSearch}%");
            });
        }
        
        $glaze_outers = $outerQuery->latest()
            ->paginate($outerPerPage, ['*'], 'outer_page')
            ->appends($request->except('outer_page'));
        
        $colors = Color::all();
        $permissions = $this->getUserPermissions();
        return view('glazeInsideOuter', compact(
            'glaze_insides', 'glaze_outers', 'colors',
            'insidePerPage', 'outerPerPage', 'insideSearch', 'outerSearch'  
        ), $permissions);
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
                Rule::unique($table, $field)->ignore($id),
            ],
            'colors'   => 'nullable|array',
            'colors.*' => 'exists:colors,id',
        ];
    }

    private function messages($type = 'outer')
    {
        $field = $type === 'outer' ? 'glaze_outer_code' : 'glaze_inside_code';
        
        return [
            "{$field}.required" => __("controller.validation.{$field}.required"),
            "{$field}.unique" => __("controller.validation.{$field}.unique"),
            "{$field}.max" => __("controller.validation.{$field}.max"),
            'colors.array' => __('controller.validation.colors.array'),
            'colors.*.exists' => __('controller.validation.colors.*.exists'),
        ];
    }

    public function destroyGlazeOuter(GlazeOuter $glazeOuter)
    {
        $glazeOuter->delete();
        return response()->json([
            'status' => 'success',
            'message' => __('controller.glaze_outer.deleted')
        ]);
    }

    public function destroyGlazeInside(GlazeInside $glazeInside)
    {
        $glazeInside->delete();
        return response()->json([
            'status' => 'success',
            'message' => __('controller.glaze_inside.deleted')
        ]);
    }

    public function storeGlazeInside(Request $request)
    {
        $validated = $request->validate($this->rules('inside'), $this->messages('inside'));

        $glazeInside = GlazeInside::create([
            'glaze_inside_code' => $validated['glaze_inside_code'],
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        if (isset($validated['colors'])) {
            $glazeInside->colors()->sync($validated['colors']);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('controller.glaze_inside.created'),
            'glazeInside' => $glazeInside->load('colors')
        ], 201);
    }

    public function storeGlazeOuter(Request $request)
    {
        $validated = $request->validate($this->rules('outer'), $this->messages('outer'));

        $glazeOuter = GlazeOuter::create([
            'glaze_outer_code' => $validated['glaze_outer_code'],
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        if (isset($validated['colors'])) {
            $glazeOuter->colors()->sync($validated['colors']);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('controller.glaze_outer.created'),
            'glazeOuter' => $glazeOuter->load('colors')
        ], 201);
    }
    
    public function updateGlazeInside(Request $request, GlazeInside $glazeInside)
    {
        $validated = $request->validate($this->rules('inside', $glazeInside->id), $this->messages('inside'));

        $glazeInside->update([
            'glaze_inside_code' => $validated['glaze_inside_code'],
            'updated_by' => auth()->id(),
        ]);

        if (isset($validated['colors'])) {
            $glazeInside->colors()->sync($validated['colors']);
        } else {
            $glazeInside->colors()->detach();
        }

        return response()->json([
            'status' => 'success',
            'message' => __('controller.glaze_inside.updated'),
            'glazeInside' => $glazeInside->load('colors')
        ], 200);
    }

    public function updateGlazeOuter(Request $request, GlazeOuter $glazeOuter)
    {
        $validated = $request->validate($this->rules('outer', $glazeOuter->id), $this->messages('outer'));

        $glazeOuter->update([
            'glaze_outer_code' => $validated['glaze_outer_code'],
            'updated_by' => auth()->id(),
        ]);

        if (isset($validated['colors'])) {
            $glazeOuter->colors()->sync($validated['colors']);
        } else {
            $glazeOuter->colors()->detach();
        }

        return response()->json([
            'status' => 'success',
            'message' => __('controller.glaze_outer.updated'),
            'glazeOuter' => $glazeOuter->load('colors')
        ], 200);
    }
}
