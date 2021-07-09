<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use App\User;
use App\Setting;
use Validator;
use DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $builder = Invoice::query();
        if(!empty($params)){
            if(!empty($params['number'])){
                $builder->where(['number' => $params['number']]);
            }
            if(!empty($params['status'])){
                $builder->where(['status' => $params['status']]);
            }
            if(!empty($params['date_from']) && !empty($params['date_to'])){
                $builder->whereBetween('date', [$params['date_from'], $params['date_to']]);
            }
            if(!empty($params['inn'])){
                $builder->where(['inn' => $params['inn']]);
            }
        }
        $builder->orderBy('id', 'DESC');
        $invoices = $builder->with(['user'])->paginate(12);
        return response()->json(['success' => true, 'result' => $invoices]);
    }

    public function userInvoice(Request $request)
    {
        $user = $request->user();
        $builder = Invoice::query()->where(['user_id' => $user->id]);
        $params = $request->all();
        if(count($params) > 0){
            if(!empty($params['date_from']) && !empty($params['date_to'])){
                $builder->whereBetween('created_at', [$params['date_from'], $params['date_to']]);
            }else{
                if(!empty($params['date_from'])){
                    $builder->whereBetween('created_at', [$params['date_from']." 00:00:00", date('Y-m-d h:m:s')]);
                }
                if(!empty($params['date_to'])){
                    $builder->where('created_at', '<=', $params['date_to']." 00:00:00");
                }
            }
            $invoices = $builder->orderBy('id', 'DESC')->with(['user'])->paginate(12);
        }else{
            $invoices = Invoice::where(['user_id' => $user->id])->orderBy('id', 'DESC')->with(['user'])->paginate(12);
        }
        return response()->json(['success' => true, 'result' => $invoices]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $invoice = Invoice::where(['id' => $id])->with(['user'])->first();
        if(!$invoice){
            return response()->json(['error' => true, 'message' => 'Not found']);
        }
        return response()->json(['success' => true,'result' => $invoice]);
    }

    public function userShow(Request $request, $id)
    {
        $user = $request->user();
        $invoice = Invoice::where(['id' => $id])->where(['user_id' => $user->id])->first();
        if(!$invoice){
            return response()->json(['error' => true, 'message' => 'Not found'],404);
        }
        return response()->json(['success' => true,'result' => $invoice]);
    }

    public function act(Request $request)
    {
        $user = $request->user();
        $result = [];
        $invoices = $user->invoice;
        foreach($invoices as $key => $invoice){
            $summa = 0;
            $applications = $invoice->proposal->application;
            foreach($applications as $app){
                $summa = $summa + $app->sum;
                $result[$key]['invoice']['invsumma'] = $summa;
                $result[$key]['invoice']['invdate'] = date('d-m-Y',strtotime($invoice->updated_at));
            }
        }
        $payments = $user->payment;
        foreach($payments as $k => $payment){
            $result[$k]['payment']['paysumma'] = $payment->receipt;
            $result[$k]['payment']['paydate'] = date('d-m-Y', strtotime($payment->updated_at));
        }
        if($result){
            return response()->json(['succcess' => true, 'result' => $result]);
        }
        return response()->json(['error' => true, 'message' => 'Нет операций для отображения']);
    }

    public function adminAct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date_to' => 'required|date',
            'date_from' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $user = $request->user();
        $client = User::find($id);
        if(!$client){
            return response()->json(['error' => true, 'message' => 'Ползователь не найден']);
        }
        $result = [];
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');

        if($date_from <= date('Y-m-d',strtotime('2019-01-01'))){
            //bez ostatok
            $ostatok = 0;
        }else{
            //s ostatok
            $inv_summa = 0;
            $pay_summa = 0;
            //old invoices from date_from
            $old_invs = DB::select("SELECT i.id, i.date, i.status,a.id,a.status,a.invoice_id,
                SUM(a.sum) AS summa FROM `invoices` AS i
                LEFT JOIN `applications` AS a ON i.id = a.invoice_id
                WHERE a.user_id = '{$client->id}' AND a.status = 'accepted' AND i.status = 'accepted'
                AND a.deleted_at IS NULL
                AND a.invoice_id IS NOT NULL
                AND a.given != 0
                AND (i.date BETWEEN '2019-01-01' AND '$date_from')
                GROUP BY a.invoice_id"
            );
            //old payments from date_from
            $pays = DB::select("SELECT id,status,receipt,user_id FROM `payments`
                                WHERE user_id = 395
                                AND deleted_at IS NULL
                                AND (date BETWEEN '2019-01-01' AND '$date_from' )"
                            );
            foreach($old_invs as $inv){
                $inv_summa = $inv_summa + $inv->summa;
            }
            foreach($pays as $pay){
                $pay_summa = $pay_summa + $pay->receipt;
            }
            $ostatok = $pay_summa - $inv_summa;
        }

        $invs = DB::select("SELECT i.id, i.date,i.number, i.status,a.id,a.status,a.invoice_id,
                            SUM(a.sum) AS summa FROM `invoices` AS i
                            LEFT JOIN `applications` AS a ON i.id = a.invoice_id
                            WHERE a.user_id = '{$client->id}' AND a.status = 'accepted' AND i.status = 'accepted'
                            AND a.deleted_at IS NULL
                            AND a.invoice_id IS NOT NULL
                            AND a.given != 0
                            AND (i.date BETWEEN '$date_from' AND '$date_to' )
                            GROUP BY a.invoice_id"
                        );
        if($invs != null){
            foreach($invs as $key => $value){
                $result['items'][$key]['invoice']['invsumma'] = round($value->summa,2);
                $result['items'][$key]['invoice']['number'] = $value->number;
                $result['items'][$key]['invoice']['invdate'] = date('d-m-Y',strtotime($value->date));
            }
        }
        $payments = DB::select("SELECT id,status,receipt,details,date,user_id FROM `payments`
                                WHERE user_id = '{$client->id}'
                                AND deleted_at IS NULL
                                AND (date BETWEEN '$date_from' AND '$date_to' )"
                            );
        if($payments){
            foreach($payments as $k => $payment){
                $result['items'][$k]['payment']['paysumma'] = $payment->receipt;
                $result['items'][$k]['payment']['details'] = $payment->details;
                $result['items'][$k]['payment']['paydate'] = date('d-m-Y', strtotime($payment->date));
            }
        }
        if($result){
            $result['ostatok'] = round($ostatok,2);
            return response()->json(['succcess' => true, 'result' => $result]);
        }
        return response()->json(['error' => true, 'message' => 'Нет операций для отображения']);
    }
}
