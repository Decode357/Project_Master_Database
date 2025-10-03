<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use App\Models\{
    Color, Glaze, Effect, 
    GlazeInside, GlazeOuter
};

class ColorController extends Controller
{
    public function colorindex() {
        $colors = Color::orderBy('id', 'desc')->paginate(10);
        return view('color',compact('colors'));
    }
    
    public function destroyColor(Color $color)
    {
        $color->delete();

        return redirect()->route('color.index')->with('success', 'Color deleted successfully.');
    }
}
