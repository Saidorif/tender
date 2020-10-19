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
        return response()->json(['success' => true,'result' => $tenders]);
    }

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $builder = Direction::query();
        $builder->where('name','LIKE', '%'.$inputs['name'].'%');
        $builder->orWhere('pass_number','LIKE', '%'.$inputs['name'].'%');
        $directions = $builder->get();
        $direction_ids = $directions->pluck(['id']);

        $tenderBuilder = Tender::query();
        if(count($directions) > 0){
            $tenderBuilder->whereJsonContains('direction_ids', $direction_ids);
        }
        $tenders = $tenderBuilder->get();
        return response()->json([
            'success' => true,
            'result' => $tenders,
        ]);
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
            'data' => 'required|array',
            'data.*.*.direction_id' => 'required|integer',
            'data.*.*.reys_id' => 'nullable|array',
            'data.*.*.reys_id.*' => 'required|integer',
            'time' => 'required|string',
            'address' => 'required|string',
            'data.*.*.status' => ['required',Rule::in(['all','custom'])],
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
        foreach ($data as $key => $d) {
            foreach ($d as $key => $value) {
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
        }
        $direction_ids = array_unique($direction_ids);
        $direction_ids = array_values($direction_ids);
        //Store to DB
        
        $tender = Tender::create([
            'time' => $tenderTime,
            'address' => $request->input('address'),
            'direction_ids' => $direction_ids,
            'status' => 'pending',
            'created_by' => $user->id,
        ]);
        // return response()->json(['error' => true,'result' => $tender_lots]);

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

    public function update(Request $request,$id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        $validator = Validator::make($request->all(),[
            'address' => 'required|string',
            'time'    => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->only('address','time');
        $tender->update($inputs);
        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно обновлено']);
    }

    public function reject(Request $request,$id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        $validator = Validator::make($request->all(),[
            'message' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $user = $request->user();
        $inputs = $request->only('message');
        $inputs['status'] = 'rejected';
        $inputs['approved_by'] = $user->id;
        $tender->update($inputs);
        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно обновлено']);
    }

    public function complete(Request $request,$id)
    {
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }

        $user = $request->user();
        $inputs = [];
        $inputs['status'] = 'completed';
        $inputs['approved_by'] = $user->id;
        $tender->update($inputs);
        return response()->json(['success' => true,'message' => 'Объявление о тендере успешно обновлено']);
    }

    public function remove(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'direction_id' => 'required|integer',
            'reys_id' => 'required|array',
            'reys_id.*' => 'required|integer',
        ]);
        $tender = Tender::find($id);
        if(!$tender){
            return response()->json(['error' => true, 'message' => 'Объявление о тендере не найдено']);
        }
        $inputs = $request->all();
        $tender_lots = TenderLot::where(['tender_id' => $tender->id,'direction_id' => $inputs['direction_id']])->first();
        if(count($inputs['reys_id']) == 0){
            $tender->direction_ids = [];
            $tender->save();

            $tender_lots->delete();
            return response()->json([
                'success' => true,
                'message' => 'OK'
            ]);
        }else{
            $tenderlots_reys_ids = $tender_lots->reys_id;
            $result = array_diff($tenderlots_reys_ids, $inputs['reys_id']);
            $tender_lots->reys_id = array_values($result);
            $tender_lots->save();
            return response()->json([
                'success' => true,
                'inputs' => $inputs['reys_id'],
                'result_array_value' => array_values($result),
                'result' => $result,
                'message' => 'OK'
            ]);            
        }
    }
}
