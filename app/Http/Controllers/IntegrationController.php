<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\GaiToken;
use App\GaiCar;
use App\AdliyaCar;

class IntegrationController extends Controller
{
    public function adliya(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'app_id' => 'required',
            'cars' => 'required|array',
            'cars.pDateNatarius' => 'required|date',
            'cars.pKuzov' => 'required|string',
            'cars.pNumberNatarius' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $user = $request->user();
        $inputs['pID'] = Str::uuid();
        $inputs['pResource'] = 1;
        $inputs['pType'] = 1;
        $inputs['cars']['pDateNatarius'] = Carbon::parse($inputs['cars']['pDateNatarius'])->format('d.m.Y');
        $body = [];
        $body['pINN'] = $user->inn;
        // !empty($inputs['pPinfl']) ? $body['pPinfl'] = $inputs['pPinfl'] : $body['pPinfl'] = '';
        $body['pType'] = $inputs['pType'];
        $body['pID'] = $inputs['pID'];
        $body['pResource'] = $inputs['pResource'];
        $body['cars'][] = $inputs['cars'];
        // return $body;
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
                $adliya_car = AdliyaCar::create([
                    "user_id" => $user->id,
                    "app_id" => $inputs['app_id'],
                    "pINN" => $inputs['app_id'],
                    "pPinfl" => !empty($inputs['pPinfl']) ? $inputs['pPinfl'] : null ,
                    "nameOwner" => $data_resp['nameOwner'],
                    "pKuzov" => $data_resp['results'][0]['pKuzov'],
                    "pNumberNatarius" => $data_resp['results'][0]['pNumberNatarius'],
                    "pDateNatarius" => $data_resp['results'][0]['pDateNatarius'],
                    "startDate" => $data_resp['results'][0]['startDate'],
                    "expirationDate" => $data_resp['results'][0]['expirationDate'],
                    "resultCode" => $data_resp['resultCode'],
                    "resultNote" => $data_resp['resultNote'],
                ]);
                return response()->json(['success' => true, 'result' => $data_resp]);
            }else{
                return response()->json(['error' => true, 'message' => $data_resp['resultNote']]);
            }
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error' => true, 'message' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
        }
    }

    public function getVehicleInfo(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'app_id' => 'required',
            'pTexpassportSery' => 'required|string',
            'pTexpassportNumber' => 'required|string',
            'pPlateNumber' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $user = $request->user();
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
                    $gai_car = GaiCar::create([
                        'user_id' => $user->id,
                        'app_id' => $inputs['app_id'],
                        'pTexpassportSery' => $inputs['pTexpassportSery'],
                        'pTexpassportNumber' => $inputs['pTexpassportNumber'],
                        'pPlateNumber' => $inputs['pPlateNumber'],
                        "pVehicleId" => $data_resp['VehicleInfo']['pVehicleId'],
                        "pMarka" => $data_resp['VehicleInfo']['pMarka'],
                        "pMadeofYear" => $data_resp['VehicleInfo']['pMadeofYear'],
                        "pNumberofplace" => $data_resp['VehicleInfo']['pNumberofplace'],
                        "pWeightAuto" => $data_resp['VehicleInfo']['pWeightAuto'],
                        "pNameOfClient" => $data_resp['VehicleInfo']['pNameOfClient'],
                        "pTypeOfAuto" => $data_resp['VehicleInfo']['pTypeOfAuto'],
                        "pTechnicalStatus" => $data_resp['VehicleInfo']['pTechnicalStatus'],
                        "pAdressOfClient" => $data_resp['VehicleInfo']['pAdressOfClient'],
                        "status" => 'pending',
                    ]);
                    return response()->json(['success' => true, 'result' => $data_resp]);
                }else{
                    return response()->json(['error' => true, 'message' => $data_resp['pAnswereMessage']]);
                }
            } catch (\Throwable $th) {
                throw $th;
                return response()->json(['error' => true, 'message' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
            }
        }
        return response()->json(['error' => true, 'message' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
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
