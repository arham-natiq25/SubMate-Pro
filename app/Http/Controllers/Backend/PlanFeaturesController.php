<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PlanFeature;
use Illuminate\Http\Request;

class PlanFeaturesController extends Controller
{

    public function index()
    {
       $plan_features =  PlanFeature::with('plan', 'feature')->get();

       return response()->json([
        'plan_features' => $plan_features
    ]);
    }

    public function store(Request $request)
    {
      $plan_features = $request->validate([
        'feature_id'=>'required|integer',
        'plan_uuid'=>'required',
        'limit_type'=>'required|string',
        'limit_value'=>'required|integer'
      ]);

      PlanFeature::create($plan_features);

      return response()->json([
        'status' => true,
        'message' => 'Plan Feature created Successfully'
    ]);
    }

    public function update(Request $request, $id)
    {
        $plan_features = $request->validate([
            'feature_id'=>'required|integer',
            'plan_uuid'=>'required',
            'limit_type'=>'required',
            'limit_value'=>'required|integer'
          ]);

          PlanFeature::where('id',$id)->update($plan_features);

          return response()->json([
            'status' => true,
            'message' => 'Plan Feature Updated  Successfully'
        ]);
    }

    public function destroy($id)
    {

        $plan_feature = PlanFeature::findOrFail($id);


        $delete = $plan_feature->delete();

        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => 'Plan Feature Deleted Successfully'
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }
}
