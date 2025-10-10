<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{
    Glaze, Status, Effect, 
    GlazeInside, GlazeOuter, Image
};
 
class GlazeController extends Controller
{
    public function glazeindex()
    {        
        $relations = [
            'status', 'updater', 'effect.colors',        
            'glazeInside.colors', 'glazeOuter.colors', 'image'
        ];

        $glazes = Glaze::with($relations)->latest()->paginate(10);

        $data = [
            'statuses'     => Status::all(),
            'effects'      => Effect::all(),
            'glazeOuters'  => GlazeOuter::all(),
            'glazeInsides' => GlazeInside::all(),
            'images'       => Image::all(),
        ];
        
        return view('glaze', array_merge($data, compact('glazes')));
    }

    private function rules($id = null)
    {
        return [
            'glaze_code'      => [
                'required', 'string', 'max:255',
                Rule::unique('glazes', 'glaze_code')->ignore($id),
            ],
            'status_id'       => 'nullable|exists:statuses,id',
            'fire_temp'       => 'nullable|integer',
            'approval_date'   => 'nullable|date',
            'glaze_inside_id' => 'nullable|exists:glaze_insides,id',
            'glaze_outer_id'  => 'nullable|exists:glaze_outers,id',
            'effect_id'       => 'nullable|exists:effects,id',
            'image_id'        => 'nullable|exists:images,id',
        ];
    }

    public function storeGlaze(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['updated_by'] = auth()->id();

        $glaze = Glaze::create($data);
        
        return response()->json([
            'status'  => 'success',
            'message' => 'Glaze created successfully!',
            'glaze'   => $glaze
        ], 201);
    }

    public function updateGlaze(Request $request, Glaze $glaze)
    {
        $data = $request->validate($this->rules($glaze->id));
        $data['updated_by'] = auth()->id();

        $glaze->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Glaze updated successfully!',
            'glaze'   => $glaze
        ], 200);
    }

    public function destroyGlaze(Glaze $glaze)
    {
        $glaze->delete();
        return redirect()->route('glaze.index')->with('success', 'Glaze deleted successfully.',200);
    }
}
