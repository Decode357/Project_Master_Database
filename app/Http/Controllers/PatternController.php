<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use App\Models\{
    Pattern,Status, 
    Designer, Requestor, Customer, 
    Image
};

class PatternController extends Controller
{

    public function patternindex()
    {
        $patterns = Pattern::with(['requestor', 'customer', 'status', 
        'designer', 'image', 'updater'])
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('pattern', compact('patterns'));
    }

    public function destroyPattern(Pattern $pattern)
    {
        $pattern->delete();

        return redirect()->route('pattern.index')->with('success', 'Pattern deleted successfully.');
    }
}
