<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleXMLElement;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\GaiToken;
use App\GaiCar;
use App\UserCar;
use App\User;
use App\AdliyaCar;

class IntegrationController extends Controller
{
    public function adliya(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'app_id' => 'required|integer',
            'cars' => 'required|array',
            'cars.pDateNatarius' => 'required|date',
            'cars.pNumberNatarius' => 'required|string',
            'cars.auto_number' => 'required|string',
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
        $inputs['cars']['pAutoNumber'] = $inputs['cars']['auto_number'];
        $body = [];
        $body['pINN'] = $user->inn;
        // !empty($inputs['pPinfl']) ? $body['pPinfl'] = $inputs['pPinfl'] : $body['pPinfl'] = '';
        $body['pType'] = $inputs['pType'];
        $body['pID'] = $inputs['pID'];
        $body['pResource'] = $inputs['pResource'];
        $body['cars'][] = $inputs['cars'];
        //Check for if the car already in use
        $the_old_car = UserCar::where(['auto_number' => $inputs['cars']['auto_number']])->first();
        if($the_old_car){
            return response()->json(['error' => true, 'message' => 'Автомобиль уже используется']);
        }
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
                $the_old_adliya_car = AdliyaCar::where(['auto_number' => $data_resp['results'][0]['pAutoNumber']])->first();
                if($the_old_adliya_car){
                    return response()->json(['success' => true, 'result' => $the_old_adliya_car]);
                }else{
                    $adliya_car = AdliyaCar::create([
                        "user_id" => $user->id,
                        "app_id" => $inputs['app_id'],
                        "auto_number" => $data_resp['results'][0]['pAutoNumber'],
                        "pINN" => $user->inn,
                        "pPinfl" => !empty($inputs['pPinfl']) ? $inputs['pPinfl'] : null ,
                        "nameOwner" => $data_resp['nameOwner'],
                        // "pKuzov" => $data_resp['results'][0]['pKuzov'],
                        "pNumberNatarius" => $data_resp['results'][0]['pNumberNatarius'],
                        "pDateNatarius" => $data_resp['results'][0]['pDateNatarius'],
                        "startDate" => $data_resp['results'][0]['startDate'],
                        "expirationDate" => $data_resp['results'][0]['expirationDate'],
                        "resultCode" => $data_resp['resultCode'],
                        "resultNote" => $data_resp['resultNote'],
                    ]);
                }
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
            'auto_number' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $inputs['pPlateNumber'] = $inputs['auto_number'];
        $user = $request->user();
        $inputs = array_map('strtoupper', $inputs);
        //Check for if the car already in use
        $the_old_car = UserCar::where(['auto_number' => $inputs['pPlateNumber']])->first();
        if($the_old_car){
            return response()->json(['error' => true, 'message' => 'Автомобиль уже используется']);
        }
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
                    $the_old_gai_car = GaiCar::where(['pPlateNumber' => $inputs['pPlateNumber']])->first();
                    if($the_old_gai_car){
                        return response()->json(['success' => true, 'result' => $the_old_gai_car]);
                    }else{
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
                    }
                    return response()->json(['success' => true, 'result' => $data_resp]);
                }else{
                    return response()->json(['error' => true, 'message' => $data_resp['pAnswereMessage']]);
                }
            } catch (\Throwable $th) {
                throw $th;die;
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
                // throw $th;
                return false;
            }
        }
        if($gai){
            return $gai;
        }
        return false;
    }

    public function getLicenseList(Request $request,$inn)
    {
        try {
            //Send query
            $client = new \GuzzleHttp\Client();
            $response = $client->get('http://10.10.10.118/services/api/tender/get-org-data/'.$inn, [
                'auth' => [
                    'tenderuser',
                    'b2d672d1127974cdb3f5e7890cd5dafc2657bcb125c2212a5e9fd7a890c42724'
                ]
            ]);
            $data_resp = json_decode($response->getBody()->getContents(),true);
            // return $data_resp;
            if(!empty($data_resp['result']['code'])){
                return response()->json(['error' => true, 'message' => $data_resp['result']['message']]);
            }else{
                $the_user = User::where(['inn' => $inn])->first();
                if($the_user){
                    $user_cars = UserCar::where(['user_id' => $the_user->id])->get();
                    foreach($data_resp['result']['automobiles'] as $auto ){
                        foreach($user_cars as $u_car){
                            if($u_car->auto_number == $auto['automobile_number']){
                                $u_car->license_start_date = Carbon::createFromTimestamp($auto['card_start_date'])->format('Y-m-d');
                                $u_car->license_exp_date = Carbon::createFromTimestamp($auto['card_end_date'])->format('Y-m-d');
                                $u_car->license_number = $auto['card_number'];
                                $u_car->license_status = 1;
                                $u_car->save();
                            }
                        }
                    }
                }
                return response()->json(['success' => true, 'result' => $data_resp]);
            }
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error' => true, 'message' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
        }
    }

    public function checkLicense(Request $request,$auto_number)
    {
        try {
            //Send query
            $client = new \GuzzleHttp\Client();
            $response = $client->get('http://10.10.10.118/services/api/tender/get-auto-data/'.$auto_number, [
                'auth' => [
                    'tenderuser',
                    'b2d672d1127974cdb3f5e7890cd5dafc2657bcb125c2212a5e9fd7a890c42724'
                ]
            ]);
            $data_resp = json_decode($response->getBody()->getContents(),true);
            return $data_resp;
            if($data_resp['resultCode'] == 1){
                return response()->json(['success' => true, 'result' => $data_resp]);
            }else{
                return response()->json(['error' => true, 'message' => $data_resp['resultNote']]);
            }
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error' => true, 'message' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
        }
    }

    public function getAutoInfo(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'app_id' => 'required',
            'pTexpassportSery' => 'required|string',
            'pTexpassportNumber' => 'required|string',
            'auto_number' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $inputs = $request->all();
        $inputs['pRequestID'] = Str::uuid();
        $inputs['pPlateNumber'] = $inputs['auto_number'];
        $inputs = array_map('strtoupper', $inputs);
        $client = new \GuzzleHttp\Client();
        $query = '<x:Envelope
            xmlns:x="http://schemas.xmlsoap.org/soap/envelope/"
            xmlns:get="urn:megaware:/mediate/ips/MOI/GetVehicleinfoVLPrefillMIP/GetVehicleinfoVLPrefillMIP.wsdl">
            <x:Header/>
            <x:Body>
                <get:VLPrefillMIP>
                    <get:pRequestID>'.$inputs['pRequestID'].'</get:pRequestID>
                    <get:pTexpassportSery>'.$inputs['pTexpassportSery'].'</get:pTexpassportSery>
                    <get:pTexpassportNumber>'.$inputs['pTexpassportNumber'].'</get:pTexpassportNumber>
                    <get:pPlateNumber>'.$inputs['pPlateNumber'].'</get:pPlateNumber>
                    <get:pVinNumber></get:pVinNumber>
                    <get:applicantPinpp></get:applicantPinpp>
                    <get:pStir></get:pStir>
                </get:VLPrefillMIP>
            </x:Body>
        </x:Envelope>';
        try {
            $response = $client->post('https://ips.gov.uz/mediate/ips/MOI/GetVehicleinfoVLPrefillMIP?wsdl', [
                'headers' => ['Content-Type' => 'text/xml', 'charset' => 'utf-8','SOAPAction' => '/mediate/ips/MOI/GetVehicleinfoVLPrefillMIP'],
                'body' => $query
            ]);
            $data_resp = $response->getBody()->getContents();
            $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $data_resp);
            $xml = new SimpleXMLElement($response);
            $body = $xml->xpath('//envBody')[0];
            $result = json_decode(json_encode((array)$body), TRUE);
            if(!empty($result['n1VLPrefillMIPResponse'])){
                if(!empty($result['n1VLPrefillMIPResponse']['VLPrefillMIPResult'])){
                    $resp_code = (int)$result['n1VLPrefillMIPResponse']['VLPrefillMIPResult']['pResult'];
                    if($resp_code){
                        $the_result = $result['n1VLPrefillMIPResponse']['VLPrefillMIPResult']['vehicleInfoResult']['anyType'];
                        $inn = $result['n1VLPrefillMIPResponse']['VLPrefillMIPResult']['pOwnerInn'];
                        //Check for inn
                        if($user->inn != $inn){
                            return response()->json(['error' => true, 'message' => 'ИНН автомобиля не совпадает с вашим ИНН']);
                        }
                        //Check for made year
                        if($the_result['pYear'] != $inputs['date']){
                            return response()->json(['error' => true, 'message' => 'Год выпуска автомобиля не совпадает']);
                        }
                        $the_old_gai_car = GaiCar::where(['pPlateNumber' => $inputs['pPlateNumber']])->first();
                        if($the_old_gai_car){
                            return response()->json(['success' => true, 'result' => $the_old_gai_car]);
                        }else{
                            $gai_car = GaiCar::create([
                                'user_id' => $user->id,
                                'app_id' => $inputs['app_id'],
                                'pTexpassportSery' => $inputs['pTexpassportSery'],
                                'pTexpassportNumber' => $inputs['pTexpassportNumber'],
                                'pPlateNumber' => $inputs['pPlateNumber'],
                                "pVehicleId" => $the_result['pVehicleId'],
                                "pMarka" => $the_result['pModel'],
                                "pMadeofYear" => $the_result['pYear'],
                                "pNumberofplace" => $the_result['pSeats'],
                                "pWeightAuto" => $the_result['pFullWeight'],
                                "pNameOfClient" => $result['n1VLPrefillMIPResponse']['VLPrefillMIPResult']['pOwner'],
                                "pTypeOfAuto" => $the_result['pVehicleType'],
                                "pTechnicalStatus" => $the_result['pVehicleColor'],
                                "pAdressOfClient" => $the_result['pDivision'],
                                "status" => 'accepted',
                            ]);
                        }
                        return response()->json(['success' => true,'result' => $gai_car]);
                    }
                    else{
                        return response()->json(['error' => true,'message' => $result['n1VLPrefillMIPResponse']['VLPrefillMIPResult']['pComment']]);
                    }
                }
                else{
                    return response()->json(['error' => true,'message' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
                }
            }
            else{
                return response()->json(['error' => true,'message' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
            }
        }catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
        }
        return response()->json(['error' => true, 'message' => 'Что-то пошло не так. Пожалуйста, повторите попытку позже']);
    }
}
