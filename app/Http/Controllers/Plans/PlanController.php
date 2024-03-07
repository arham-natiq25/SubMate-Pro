<?php

namespace App\Http\Controllers\Plans;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PlanController extends Controller
{
    function index(Request $request)
    {
        $plans = Plan::all();

        return response()->json([
            'success'=>true,
            'plans'=>$plans
        ]);

    }
    function storePlan(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255|min:3',
            'short_description' => 'required',
            'monthly_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'year_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $uuid = Str::uuid();
        $plan = Plan::create([
            'id'=>$uuid,
            'name'=>$request->name,
            'short_description'=>$request->short_description,
            'monthly_price'=>$request->monthly_price,
            'year_price'=>$request->year_price,
            'trial'=>$request->trial
        ]);

        if ($plan) {
            return response()->json([
                'success'=>true,
                'message'=>'Plan Created Successfully'
            ]);
        }
        return response()->json([
            'success'=>false,
            'message'=>'Plan Not created'
        ]);
    }
    public function editPlan($id)
    {
        try {
            $plan = Plan::findOrFail($id);
            return response()->json([
                'success' => true,
                'plan' => $plan,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Plan not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    public function updatePlan(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|min:3',
            'short_description' => 'required',
            'monthly_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'year_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'trial' => 'boolean',
        ]);

        try {
            $plan = Plan::findOrFail($id);

            $updated = $plan->update([
                'name' => $request->name,
                'short_description' => $request->short_description,
                'monthly_price' => $request->monthly_price,
                'year_price' => $request->year_price,
                'trial' => $request->input('trial', false),
            ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Plan Updated Successfully',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Plan Not Updated',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Plan not found, return a 404 response
            return response()->json([
                'success' => false,
                'message' => 'Plan not found',
            ], 404);
        } catch (\Exception $e) {
            // Handle other unexpected exceptions
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    public function deletePlan($id)
    {
        try {
            $plan = Plan::findOrFail($id);
            $plan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Plan Deleted Successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Plan not found, return a 404 response
            return response()->json([
                'success' => false,
                'message' => 'Plan not found or already deleted',
            ], 404);
        } catch (\Exception $e) {
            // Handle other unexpected exceptions
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }


}
