<?php

namespace App\Http\Controllers\Backend\Features;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
    public function index()
    {
        $features = Feature::all();

        return response()->json([
            'features' => $features
        ]);
    }

    public function store(Request $request)
    {
        $feature = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'slug' => 'required'
        ]);

        Feature::create($feature);

        return response()->json([
            'status' => true,
            'message' => 'Feature created Successfully'
        ]);
    }


    public function update(Request $request, $id)
    {
        $feature = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'slug' => 'required'
        ]);

        $updated = Feature::where('id', $id)->update($feature);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Feature updated Successfully'
            ]);
        }
    }

    public function destroy($id)
    {

        $feature = Feature::findOrFail($id);

        $delete = $feature->delete();

        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => 'Feature Deleted Successfully'
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }
}
