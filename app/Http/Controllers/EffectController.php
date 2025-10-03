<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use App\Models\{
    Effect, Color
};

class EffectController extends Controller
{
    public function effectindex()
    {
        // Eager load colors เพื่อลด query และ join pivot table
        $effects = Effect::with('colors')
                        ->orderBy('id', 'asc')
                        ->paginate(10);

        return view('effect', compact('effects'));
    }

    public function destroyEffect(Effect $effect)
    {
        $effect->delete();

        return redirect()->route('effect.index')->with('success', 'Effect deleted successfully.');
    }
}
