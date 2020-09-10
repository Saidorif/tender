<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Direction;
use App\Region;
use App\Area;
use Validator;
use Illuminate\Validation\Rule;

class DirectionController extends Controller
{
    public function index(Request $request)
    {
        $result = Direction::with(['regionTo','regionFrom','areaFrom','areaTo'])->orderByDesc('id')->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list(Request $request)
    {
        $result = Direction::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = Direction::with(['regionTo','regionFrom','areaFrom','areaTo'])->find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $region_ids = Region::pluck('id');
        $area_ids = Area::pluck('id');
        $validator = Validator::make($request->all(), [            
            // 'name'  => 'required|string',
            'number'  => 'required|string',
            'seria'  => 'required|string',
            'region_from_id'=> ['required',Rule::in($region_ids),],
            'region_to_id'  => ['required',Rule::in($region_ids),],
            'area_from_id'  => ['nullable',Rule::in($region_ids),],
            'area_to_id'    => ['nullable',Rule::in($region_ids),],
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $direction = Direction::create($inputs);
        $direction->name = $direction->seria .'-'. $direction->number .'-'. $direction->regionFrom->name.'-***-'.$direction->regionTo->name;
        $direction->save();

        return response()->json(['success' => true, 'message' => 'Направление успешно создан']);
    }

    public function update(Request $request, $id)
    {
        $direction = Direction::find($id);
        if(!$direction){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $region_ids = Region::pluck('id');
        $area_ids = Area::pluck('id');
        $validator = Validator::make($request->all(), [            
            // 'name'  => 'required|string',
            'number'  => 'required|string',
            'seria'  => 'required|string',
            'region_from_id'=> ['required',Rule::in($region_ids),],
            'region_to_id'  => ['required',Rule::in($region_ids),],
            'area_from_id'  => ['nullable',Rule::in($region_ids),],
            'area_to_id'    => ['nullable',Rule::in($region_ids),],
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $direction->update($inputs);
        $direction->name = $direction->seria .'-'. $direction->number .'-'. $direction->regionFrom->name.'-***-'.$direction->regionTo->name;
        $direction->save();

        return response()->json(['success' => true, 'message' => 'Направление успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $result = Direction::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Направление не найден']);
        }
        $result->delete();

        return response()->json(['success' => true, 'message' => 'Направление удален']);
    }
}
