<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use App\Models\{
    Backstamp, Status, Image,
    Requestor, Customer
};
 

class BackstampController extends Controller
{
    public function backstampindex() {
        $backstamps = Backstamp::with(['requestor', 'customer', 'status', 
        'image', 'updater'])
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('backstamp', compact('backstamps'));
    }
    
    public function destroyBackstamp(Backstamp $backstamp)
    {
        $backstamp->delete();

        return redirect()->route('backstamp.index')->with('success', 'Backstamp deleted successfully.');
    }
}
