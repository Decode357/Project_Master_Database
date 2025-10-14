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

    return view('glazeInsideOuter', compact('glaze_insides', 'glaze_outers'));
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
                "unique:glaze_insides,{$field},{$id}",
                "unique:glaze_outers,{$field},{$id}",
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
}
