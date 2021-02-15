<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $contracts = Contract::orderBy('id','DESC')->with('user')->paginate(12);
        return response()->json(['success' => true, 'result' => $contracts]);
    }
    
    public function edit(Request $request,$id)
    {
        $contract = Contract::with(['user','lot','app'])->find($id);
        if(!$contract){
            return response()->json(['error' => true, 'Contract not found']);
        }
        return response()->json(['success' => true, 'result' => $contract]);
    }
}
