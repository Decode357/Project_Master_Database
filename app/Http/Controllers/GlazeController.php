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
        $glazes = Glaze::with(['status', 'updater'])
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('glaze',compact('glazes'));
    }
    
    public function destroyGlaze(Glaze $glaze)
    {
        $glaze->delete();

        return redirect()->route('glaze.index')->with('success', 'Glaze deleted successfully.');
    }
}
