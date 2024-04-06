<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TransactionRecords;
use App\Models\User;
use Illuminate\Http\Request;

class GetAllTransactionRecords extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $trx_records = TransactionRecords::with('user')->get();
        return response()->json($trx_records);
    }
}
