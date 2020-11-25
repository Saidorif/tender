<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class IntegrationController extends Controller
{
    public function adliya(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'pINN' => 'nullable|integer',
            'pPinfl' => 'nullable|string',
            'pType' => ['required',Rule::in([0,1]),],
            'cars' => 'required|array',
            'cars*.pDateNatarius' => 'required|date',
            'cars*.pKuzov' => 'required|string',
            'cars*.pNumberNatarius' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($inputs['pType'] == 0 && empty($inputs['pPinfl'])){
            return response()->json(['error' => true, 'message' => 'Персональный идентификационный номер физического лица не обнаружена']);
        }
        if($inputs['pType'] == 1 && empty($inputs['pINN'])){
            return response()->json(['error' => true, 'message' => 'Идентификационный номер налогоплательщика не обнаружена']);
        }
        $inputs['pID'] = Str::uuid();
        $inputs['pResource'] = 1;
        //Send query
        $query = json_encode($inputs);
        $client = new \GuzzleHttp\Client();
        $response = $client->post('10.190.0.162:8085/notary_mintrans_service/search', [
            'auth' => [
                'mintrans', 
                'qP7N1_gEc6'
            ],
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
            'body' => $query
        ]);
        $data_resp = json_decode($response->getBody()->getContents(),true);
        // $response = Http::post('10.190.0.162:8085/notary_mintrans_service/search', $inputs);

        return response()->json(['success' => true, 'result' => $inputs]);
    }
}
