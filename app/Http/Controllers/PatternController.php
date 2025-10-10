<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{
    Pattern, Status, Designer, 
    Requestor, Customer, Image
};

class PatternController extends Controller
{
    public function patternindex()
    {
        $relations = [
            'requestor', 'customer', 'status', 
            'designer', 'image', 'updater'
        ];

        $patterns = Pattern::with($relations)->latest()->paginate(10);

        $data = [
            'statuses'   => Status::all(),
            'designers'  => Designer::all(),
            'requestors' => Requestor::all(),
            'customers'  => Customer::all(),
            'images'     => Image::all(),
        ];

        return view('pattern', array_merge($data, compact('patterns')));
    }

    private function rules($id = null)
    {
        return [
            'pattern_code'   => [
                'required', 'string', 'max:255',
                Rule::unique('patterns', 'pattern_code')->ignore($id),
            ],
            'pattern_name'   => 'required|string|max:255',
            'requestor_id'   => 'nullable|exists:requestors,id',
            'customer_id'    => 'nullable|exists:customers,id',
            'status_id'      => 'nullable|exists:statuses,id',
            'designer_id'    => 'nullable|exists:designers,id',
            'duration'       => 'nullable|integer',
            'in_glaze'       => 'nullable|boolean',
            'on_glaze'       => 'nullable|boolean',
            'under_glaze'    => 'nullable|boolean',
            'approval_date'  => 'nullable|date',
            'image_id'       => 'nullable|exists:images,id',
        ];
    }

    public function storePattern(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['updated_by'] = auth()->id();

        $pattern = Pattern::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pattern created successfully!',
            'pattern' => $pattern
        ], 201);
    }

    public function updatePattern(Request $request, Pattern $pattern)
    {
        $data = $request->validate($this->rules($pattern->id));
        $data['updated_by'] = auth()->id();

        $pattern->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pattern updated successfully!',
            'pattern' => $pattern
        ], 200);
    }

    public function destroyPattern(Pattern $pattern)
    {
        $pattern->delete();
        return redirect()->route('pattern.index')->with('success', 'Pattern deleted successfully.',200);
    }
}
