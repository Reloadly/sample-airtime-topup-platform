<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use App\Models\Invoice;
use App\Models\Operator;
use App\Models\System;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class ApiController extends Controller
{

    public function operators(Request $request)
    {
        $user = User::find($request->user()['id']);
        if(!$user)
            return response()->json(['errors' => ['error' => 'User not found.']],422);
        $operators = $user['api_operators'];
        $operators->makeHidden(['rid','international_discount','commission','local_discount']);
        foreach ($operators as $key => $operator){
            if(isset($operator['rates'])) {
                unset($operator['rates']['user_id']);
                unset($operator['rates']['operator_id']);
            }
            $operators[$key] = $operator;
        }
        return response()->json($operators);
    }

    public function operator($id,Request $request)
    {
        $user = User::find($request->user()['id']);
        if(!$user)
            return response()->json(['errors' => ['error' => 'User not found.']],422);
        $operator = $user->api_operators()->where('id', $id)->first();
        $operator->makeHidden(['rid','international_discount','commission','local_discount']);
        if(isset($operator['rates'])) {
            unset($operator['rates']['user_id']);
            unset($operator['rates']['operator_id']);
        }
        return response()->json($operator);
    }

    public function getOperatorsForCountry($id, Request $request){
        $user = User::find($request->user()['id']);
        if(!$user)
            return response()->json(['errors' => ['error' => 'User not found.']],422);
        $operators = $user->api_operators()->where('country_id', $id)->get();
        $operators->makeHidden(['rid','international_discount','commission','local_discount']);
        foreach ($operators as $key => $operator){
            if(isset($operator['rates'])) {
                unset($operator['rates']['user_id']);
                unset($operator['rates']['operator_id']);
            }
            $operators[$key] = $operator;
        }
        return response()->json($operators);
    }

    public function countries(){
        return response()->json(Country::all());
    }

    public function getToken(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['errors' => ['error' => 'email or password missing.']],422);

        $user = User::where('email', $request['email'])->orWhere('username', $request['email'])->first();
        if(!$user)
            return response()->json(['errors' => ['error' => 'User not found.']],422);
        if(Hash::check($request['password'], $user['password'])){
            $previousToken = DB::table('oauth_access_tokens')->where('user_id', '=', $user->id)->delete();
            return response()->json($user->createToken($user['email']));
        }
        return response()->json(['errors' => ['error' => 'Invalid Credentials.']],422);
    }

    public  function sendTopUp(Request $request){

        $user = User::find($request->user()['id']);
        if(!$user)
            return response()->json(['errors' => ['error' => 'User not found.']],422);
        if(isset($user['user_role']) && ($user['user_role']['name'] != 'RESELLER'))
            return response()->json(['errors' => ['error' => 'This Action is for Resellers Only.']],422);

        $validator = Validator::make($request->all(), [
            'operator' => 'required',
            'number' => 'required',
            'ref' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['errors' => ['error' => 'operator or number or ref is missing.']],422);

        $topup = Topup::where('ref_no',$request['ref'])->first();
        if ($topup)
            return response()->json(['errors' => ['error' => 'Ref No is not unique.']],422);

        $isLocal = isset($request['is_local']) && $request['is_local'] == true;
        $operator = Operator::find($request['operator']);
        $validator = null;
        if ($isLocal)
            $validator = Validator::make($request->all(), [
                'local_amount' => 'required'
            ]);
        else
            $validator = Validator::make($request->all(), [
                'amount' => 'required'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => ['error' => 'amount not found.']],422);

        $amount =  $isLocal?($request['local_amount'] * (1 / $operator['fx_rate'])):($request['amount']);
        $number = $request['number'];

        if($user['balance_value'] < $amount)
            return response()->json( ['error' => 'Insufficient Balance for Transfer']);

        $invoice = new Invoice();
        $invoice['user_id'] = $user['id'];
        $invoice['amount'] = 0;
        $invoice['currency_code'] = $operator['sender_currency_code'];
        $invoice->save();

        $topup = Topup::create([
            'user_id' => $user['id'],
            'ref_no' => $request['ref'],
            'operator_id' => $operator['id'],
            'invoice_id' => $invoice['id'],
            'topup' => $isLocal?
                $request['local_amount']:
                ($operator['fx_rate'] * $request['amount']),
            'amount' => $isLocal?
                ($request['local_amount'] * (1 / $operator['fx_rate']))
                :
                ($request['amount']),
            'number' => $number,
            'sender_currency' => $operator['sender_currency_code'],
            'receiver_currency' => $operator['destination_currency_code'],
            'is_local' => $isLocal
        ]);
        $invoice['amount']+=$amount;
        $invoice['type'] = 'Topup';

        $invoice->save();

        $accountTransaction = AccountTransaction::firstOrCreate(['invoice_id' => $invoice['id']],[
            'user_id' => $invoice['user_id'],
            'invoice_id' => $invoice['id'],
            'amount' => $invoice['amount'],
            'currency' => $invoice['currency_code'],
            'type' => 'DEBIT',
            'description' => 'Invoice Paid with Balance. Invoice: '.$invoice['id'],
            'ending_balance' => $user['balance_value'] - $invoice['amount']
        ]);
        if($accountTransaction) {
            $invoice['status'] = 'PAID';
            $invoice['payment_method'] = 'BALANCE';
            $invoice->save();
            $topup['status'] = 'PENDING';
            $topup->save();
            $topup->sendTopup();
            return response()->json([
                'success' => [
                    'message' => 'Transaction created. Please check internal transaction status for details.',
                    'transaction' => $topup->makeHidden(['user_id','file_entry_id','response','operator'])
                ]
            ],200);
        }

    }


}
