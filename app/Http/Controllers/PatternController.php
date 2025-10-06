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
        ->orderBy('id', 'desc')->paginate(10);

        $statuses = Status::all();
        $designers = Designer::all();
        $requestors = Requestor::all();
        $customers = Customer::all();
        $images = Image::all();

        return view('pattern', compact('patterns', 'statuses', 'designers', 'requestors', 'customers', 'images'));
    }

    public function destroyPattern(Pattern $pattern)
    {
        $pattern->delete();

        return redirect()->route('pattern.index')->with('success', 'Pattern deleted successfully.');
    }
}
