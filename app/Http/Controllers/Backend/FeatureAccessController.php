<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeatureAccess;


class FeatureAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feature_access = FeatureAccess::with('feature')->get();

        return response()->json([
            'feature_access'=>$feature_access
            ]);
    }


    public function store(Request $request)
    {
     $feature_access =  $request->validate([

        'feature_id'=>'required|integer', // its feature id basically
        'access'=>'required|boolean',
        'limit'=>'required|integer'
    ]);

    FeatureAccess::create($feature_access);

    return response()->json([
        'status' => true,
        'message' => 'Feature Access created Successfully'
    ]);

    }




    public function update(Request $request, $id)
    {
        $feature_access =  $request->validate([

            'feature_id'=>'required|integer', // its feature id basically
            'access'=>'required|boolean',
            'limit'=>'required|integer'
        ]);

        FeatureAccess::where('id',$id)->update($feature_access);

        return response()->json([
            'status' => true,
            'message' => 'Feature Access updated Successfully'
        ]);
    }

    public function destroy($id)
    {
        $feature_access = FeatureAccess::findOrFail($id);


        $delete = $feature_access->delete();

        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => ' Feature access Deleted Successfully'
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }
}
