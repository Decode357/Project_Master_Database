<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use App\Models\{
    Glaze, Status, 
    Effect, GlazeInside, GlazeOuter, 
    Image
};
 
class GlazeController extends Controller
{
    public function storeGlaze(Request $request)
    {
        $data = $request->validate([
            'glaze_code'      => 'required|string|max:255|unique:glazes,glaze_code',
            'status_id'       => 'nullable|exists:statuses,id',
            'fire_temp'      => 'nullable|integer',
            'approval_date'  => 'nullable|date',
            'glaze_inside_id' => 'nullable|exists:glaze_insides,id',
            'glaze_outer_id'  => 'nullable|exists:glaze_outers,id',
            'effect_id'      => 'nullable|exists:effects,id',
            'image_id'       => 'nullable|exists:images,id',
        ]);

        $glaze = Glaze::create([
            'glaze_code'      => $data['glaze_code'],
            'status_id'       => $data['status_id'] ?? null,
            'fire_temp'      => $data['fire_temp'] ?? null,
            'approval_date'  => $data['approval_date'] ?? null,
            'glaze_inside_id' => $data['glaze_inside_id'] ?? null,
            'glaze_outer_id'  => $data['glaze_outer_id'] ?? null,
            'effect_id'      => $data['effect_id'] ?? null,
            'image_id'       => $data['image_id'] ?? null,
            'updated_by'     => auth()->id(),
        ]);
        
        return response()->json([
            'status'  => 'success',
            'message' => 'Glaze created successfully!',
            'glaze'   => $glaze
        ], 200);
    }
    public function glazeindex() {        
        $glazes = Glaze::with([
            'status', 
            'updater',
            'effect.colors',        // เพิ่ม colors ของ effect
            'glazeInside.colors',  // เพิ่ม colors ของ glaze_inside
            'glazeOuter.colors',   // เพิ่ม colors ของ glaze_outer
            'image'
        ])
        ->orderBy('id', 'desc')
        ->paginate(10);

        $statuses = Status::all();
        $effects = Effect::all();
        $glazeOuters = GlazeOuter::all();
        $glazeInsides = GlazeInside::all();
        $images = Image::all();
        
        return view('glaze',compact('glazes', 'statuses', 'effects', 'glazeOuters', 'glazeInsides', 'images'));
    }
    
    public function destroyGlaze(Glaze $glaze)
    {
        $glaze->delete();

        return redirect()->route('glaze.index')->with('success', 'Glaze deleted successfully.');
    }
}
