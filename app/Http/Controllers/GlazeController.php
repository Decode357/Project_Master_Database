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
