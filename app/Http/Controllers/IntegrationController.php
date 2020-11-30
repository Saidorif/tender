<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\GaiToken;

class IntegrationController extends Controller
{
    public function adliya(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'pINN' => 'nullable|integer',
            'pPinfl' => 'nullable|string',
            'pType' => ['required',Rule::in([0,1]),],
            'cars' => 'required|array',
            'cars.pDateNatarius' => 'required|date',
            'cars.pKuzov' => 'required|string',
            'cars.pNumberNatarius' => 'required|string',
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
        $inputs['cars']['pDateNatarius'] = Carbon::parse($inputs['cars']['pDateNatarius'])->format('d.m.Y');
        $body = [];
        $body['pINN'] = $inputs['pINN'];
        !empty($inputs['pPinfl']) ? $body['pPinfl'] = $inputs['pPinfl'] : $body['pPinfl'] = '';
        $body['pType'] = $inputs['pType'];
        $body['pID'] = $inputs['pID'];
        $body['pResource'] = $inputs['pResource'];
        $body['cars'][] = $inputs['cars'];
        try {
            //Send query
            $query = json_encode($body);
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
            if($data_resp['resultCode'] == 1){
                return response()->json(['success' => true, 'result' => $data_resp]);
            }else{
                return response()->json(['error' => true, 'result' => $data_resp['resultNote']]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'result' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
        }
    }

    public function getVehicleInfo(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'pTexpassportSery' => 'required|string',
            'pTexpassportNumber' => 'required|string',
            'pPlateNumber' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $inputs = array_map('strtoupper', $inputs);
        $gai = $this->getGaiToken();
        if($gai){
            try {
                //Send query
                $query = json_encode($inputs);
                $client = new \GuzzleHttp\Client();
                $response = $client->post('http://10.190.0.77:9090/api/GetVehicleShortInfo', [
                    'headers' => [
                        'Content-Type' => 'application/json', 
                        'Accept' => 'application/json',
                        'Authorization' => "Bearer {$gai->token}"
                    ],
                    'body' => $query
                ]);
                $data_resp = json_decode($response->getBody()->getContents(),true);
                if($data_resp['pAnswereId'] == 1){
                    return response()->json(['success' => true, 'result' => $data_resp]);
                }else{
                    return response()->json(['error' => true, 'result' => $data_resp['pAnswereMessage']]);
                }
            } catch (\Throwable $th) {
                return response()->json(['error' => true, 'result' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
            }
        }
        return response()->json(['error' => true, 'result' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
    }

    //GAI get token (authentication)
    public function getGaiToken()
    {
        $gai = GaiToken::where('expires_in', '>', date('Y-m-d H:m:s'))->first();
        if(!$gai){
            try {
                //Send query and get token
                $body = "username=MINTRANS&password=m1ntr@n$2OI9&grant_type=password";
                $client = new \GuzzleHttp\Client();
                $response = $client->post('http://10.190.0.77:9090/token', [
                    'headers' => ['Content-Type' => 'text/plain', 'Accept' => 'text/plain'],
                    'body' => $body
                ]);
                $data_resp = json_decode($response->getBody()->getContents(),true);
                if($data_resp['access_token']){
                    $current_timestamp = Carbon::now()->timestamp;
                    $expires_in = Carbon::createFromTimestamp($current_timestamp + $data_resp['expires_in'])->toDateTimeString();
                    $gai = GaiToken::create([
                        'token' => $data_resp['access_token'],
                        'expires_in' => $expires_in,
                    ]);
                }
            } catch (\Throwable $th) {
                //throw $th;
                return false;
            }
        }
        if($gai){
            return $gai;
        }
        return false;
    }
}
