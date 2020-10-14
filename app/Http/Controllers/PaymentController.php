<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\User;
use Validator;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $result = Payment::orderBy('id', 'DESC')->with(['user','createdBy','updatedBy'])->paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit(Request $request,$id)
    {
        $payment = Payment::with(['user','createdBy','updatedBy'])->find($id);
        if(!$payment){
            return response()->json(['error' => true, 'message' => 'Платеж не найден']);
        }
        return response()->json(['success' => true, 'result' => $payment]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'summ' => 'required|numeric',
            'details' => 'required|string',
            'inn' => 'required|string|min:9|max:9',
            'date' => 'required|date',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $user = $request->user();
        //Get Client by inn number
        $client = User::where(['inn' => $inputs['inn']])->first();
        if(!$client){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден с этим номером ИНН']);
        }
        $inputs['user_id'] = $client->id;
        $inputs['created_by'] = $user->id;
        $payment = Payment::create($inputs);

        return response()->json(['success' => true, 'message' => 'Платеж успешно создан']);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'summ' => 'required|numeric',
            'details' => 'required|string',
            'inn' => 'required|string|min:9|max:9',
            'date' => 'required|date',
            'status' => ['nullable',Rule::in(['active', 'draft']),],
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $payment = Payment::find($id);
        if(!$payment){
            return response()->json(['error' => true, 'message' => 'Платеж не найден']);
        }
        if($payment->status == 'active'){
            return response()->json(['error' => true, 'message' => 'Платеж уже активный']);
        }

        $inputs = $request->only('summ','details','inn','date','status');
        $user = $request->user();
        //Get Client by inn number
        $client = User::where(['inn' => $inputs['inn']])->first();
        if(!$client){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден с этим номером ИНН']);
        }
        $inputs['user_id'] = $client->id;
        $inputs['updated_by'] = $user->id;
        $status = $payment->status;
        if(!empty($inputs['status'])){
            $status = $inputs['status'];
        }
        unset($inputs['status']);
        
        $payment->update($inputs);

        if($status == 'active'){
            if($payment->status == 'draft'){
                $client->balance += $inputs['summ'];
                $client->save();
                
                $payment->status = $status;
                $payment->save();
            }
        }
        if($status == 'draft'){
            if($payment->status == 'active'){
                $client->balance -= $inputs['summ'];
                $client->save();

                $payment->status = $status;
                $payment->save();
            }
        }

        return response()->json(['success' => true, 'message' => 'Платеж успешно обновлено']);
    }

    public function destroy(Request $request,$id)
    {
        $payment = Payment::find($id);
        if(!$payment){
            return response()->json(['error' => true, 'message' => 'Платеж не найден']);
        }
        if($payment->status == 'active'){
            return response()->json(['error' => true, 'message' => 'Вы не можете удалить активный платеж']);
        }
        $payment->delete();
        return response()->json(['success' => true, 'message' => 'Платеж успешно удален']);
    }


}
