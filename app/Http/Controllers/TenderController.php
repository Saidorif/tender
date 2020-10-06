<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Tender;
use App\TenderLot;
use App\Direction;
use Carbon\Carbon;
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
            '.*.direction_id' => 'required|integer',
            '.*.reys_id' => 'required|array',
            '.*.reys_id.*' => 'required|integer',
            '.*.time' => 'required|string',
            '.*.address' => 'required|string',
            '.*.status' => ['required',Rule::in(['all','custom'])],
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $data = $request->all();
        $user = $request->user();
        $direction_ids = [];
        //Get direction_ids in to one array
        foreach ($data as $key => $value) {
            $direction_ids[] = $value['direction_id'];
        }
        //Store to DB
        $tenderTime = Carbon::parse($data[0]['time'])->format('Y-m-d H:i:s');
        $tender = Tender::create([
            'time' => $tenderTime,
            'address' => $data[0]['address'],
            'direction_ids' => $direction_ids,
            'status' => $data[0]['status'],
            'created_by' => $user->id,
        ]);

        foreach ($data as $key => $item) {
            $tenderLot = TenderLot::create([
                'tender_id' => $tender->id,
                'direction_id' => $item['direction_id'],
                'time' => Carbon::parse($item['time'])->format('Y-m-d H:i:s'),
                'reys_id' => $item['reys_id'],
                'status' => $item['status'],
            ]);
        }

        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно создано']);
    }
}
