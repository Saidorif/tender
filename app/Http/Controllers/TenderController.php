<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Tender;
use App\Direction;
use Illuminate\Validation\Rule;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $result = Tender::paginate(12);
        return response()->json(['success' => true,'result' => $result]);
    }

    public function edit($id)
    {
        $result = Tender::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
    }

    public function store(Request $request)
    {
        $direction_ids = Direction::pluck('id');
        $validator = Validator::make($request->all(),[
            'direction_ids' => 'required|array',
            'direction_ids.*' => ['required',Rule::in([$direction_ids])],
            'time' => 'required|string',
            'address' => 'required|string',
            'type' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $inputs = $request->all();
        $user = $request->user();

        $inputs['status'] = 'pending';
        $inputs['created_by'] = $user->id;

        return response()->json(['success' => true,'inputs' => $inputs ,'result' => $direction_ids]);

        //Store to DB
    }
}
