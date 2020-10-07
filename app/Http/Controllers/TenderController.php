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
        $tenders = Tender::with(['tenderlots'])->paginate(12);

        // $tenders->getCollection()->transform(function ($value) {
        //     $directions = Direction::with(['type'])->whereIn('id',$value->direction_ids)->get();
        //     $value->directions = $directions;
        //     return $value;
        // });
        return response()->json(['success' => true,'result' => $tenders]);
    }

    public function edit($id)
    {
        $result = Tender::with(['tenderlots','createdBy','approvedBy'])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $direction_ids = Direction::pluck('id');
        $validator = Validator::make($request->all(),[
            'data.*.direction_id' => 'required|integer',
            'data.*.reys_id' => 'required|array',
            'data.*.reys_id.*' => 'required|integer',
            'time' => 'required|string',
            'address' => 'required|string',
            'data.*.status' => ['required',Rule::in(['all','custom'])],
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $data = $request->input('data');
        $user = $request->user();
        $direction_ids = [];
        $tender_lots = [];
        $tenderTime = Carbon::parse($request->input('time'))->format('Y-m-d H:i:s');
        //Get direction_ids in to one array
        foreach ($data as $key => $value) {
            $direction_ids[] = $value['direction_id'];
            $tender_lots[$value['direction_id']]['direction_id'] = $value['direction_id'];
            $tender_lots[$value['direction_id']]['time'] = $tenderTime;
            $tender_lots[$value['direction_id']]['status'] = $value['status'];
            if(isset($tender_lots[$value['direction_id']]['reys_id'])){
                $tender_lots[$value['direction_id']]['reys_id'] = array_merge($value['reys_id'],$tender_lots[$value['direction_id']]['reys_id']);
            }else{
                $tender_lots[$value['direction_id']]['reys_id'] = $value['reys_id'];
            }
        }
        $direction_ids = array_unique($direction_ids);
        //Store to DB
        
        $tender = Tender::create([
            'time' => $tenderTime,
            'address' => $request->input('address'),
            'direction_ids' => $direction_ids,
            'status' => 'pending',
            'created_by' => $user->id,
        ]);

        foreach ($tender_lots as $key => $item) {
            $tenderLot = TenderLot::create([
                'tender_id' => $tender->id,
                'direction_id' => $item['direction_id'],
                'time' => $tenderTime,
                'reys_id' => $item['reys_id'],
                'status' => $item['status'],
            ]);
        }

        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно создано']);
    }
}
