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
    public function storePattern(Request $request)
    {
        $data = $request->validate([
            'pattern_code'      => 'required|string|max:255|unique:patterns,pattern_code',
            'pattern_name'      => 'required|string|max:255',
            'requestor_id'      => 'nullable|exists:requestors,id',
            'customer_id'       => 'nullable|exists:customers,id',
            'status_id'         => 'nullable|exists:statuses,id',
            'designer_id'       => 'nullable|exists:designers,id',
            'duration'          => 'nullable|integer',
            'in_glaze'         => 'nullable|boolean',
            'on_glaze'        => 'nullable|boolean',
            'under_glaze'     => 'nullable|boolean',
            'approval_date' => 'nullable|date',
            'image_id'          => 'nullable|exists:images,id',
        ]);

        $pattern = Pattern::create([
            'pattern_code'      => $data['pattern_code'],
            'pattern_name'      => $data['pattern_name'],
            'requestor_id'      => $data['requestor_id'] ?? null,
            'customer_id'       => $data['customer_id'] ?? null,
            'status_id'         => $data['status_id'] ?? null,
            'designer_id'       => $data['designer_id'] ?? null,
            'duration'          => $data['duration'] ?? null,
            'in_glaze'         => $data['in_glaze'] ?? false,
            'on_glaze'        => $data['on_glaze'] ?? false,
            'under_glaze'     => $data['under_glaze'] ?? false,
            'approval_date'    => $data['approval_date'] ?? null,
            'image_id'          => $data['image_id'] ?? null,
            'updated_by'       => auth()->id(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pattern created successfully!',
            'pattern'   => $pattern
        ], 200);
    }
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
