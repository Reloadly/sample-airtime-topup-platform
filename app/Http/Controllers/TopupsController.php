<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\Operator;
use App\Models\System;
use Illuminate\Http\Request;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class TopupsController extends Controller
{
    public function index(){
        $user = Auth::user();
        if (!isset($user) || !isset($user['user_role']))
            return response()->json(['errors' => [ 'error' => 'User or User Role not found.']],422);
        return view('dashboard.topups.home', [
            'page' => [
                'type' => 'dashboard'
            ],
            'topups' => $user['user_role']['name'] == 'ADMIN'?Topup::with('discount_transaction')->get():$user->topups()->with('discount_transaction')->get()
        ]);
    }

    public function getHomePageTopup(){
        if(Auth::user())
            $token = Auth::user()->createToken('Token')->accessToken;
        else
            $token = User::admin()->createToken('Token')->accessToken;
        return view('dashboard.topup', [
            'countries' => Country::all(),
            'token' => $token,
            'send'=>"0"
        ]);
    }

    public function getWizard(){
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        $token = $user->createToken('Token')->accessToken;
        return view('dashboard.topups.wizard', [
            'page' => [
                'type' => 'dashboard'
            ],
            'countries' => Country::all(),
            'token' => $token,
            'send'=>true
        ]);
    }

    public function getPinDetail($id){
        return view('dashboard.topups.pin',[
            'topup' => Topup::find($id)
        ]);
    }

    public function retrySendTopup($id){
        $topup = Topup::find($id);
        if(!$topup)
            return response()->json(['errors' => ['error' => 'Topup not found.']],422);
        $user = Auth::user();
        if (!isset($user) || !isset($user['user_role']))
            return response()->json(['errors' => [ 'error' => 'User or User Role not found.']],422);
        if ($user['user_role']['name'] !== 'ADMIN')
            return response()->json(['errors' => ['error' => 'Not Authorized to perform such action.']],422);
        $topup['status'] = 'PENDING';
        $topup->save();
        $status = $topup->sendTopup(true);
        if($status == 'FAIL')
            return response()->json(['errors' => ['error' => @$topup['response']['message']]],422);
        elseif ($status == 'SUCCESS')
            return response()->json([
                'location' => '/topups/history',
                'message' => 'Topup Sent. Redirecting Now'
            ]);
    }

    public  function sendTopUp(Request $request){
        $request->validate([
            'operator' => 'required',
            'number' => 'required'
        ]);
        $user = Auth::user();
        if (!isset($user))
            return response()->json([
                'location' => '/register',
                'message' => 'Please Register First'
            ]);
        $isLocal = isset($request['is_local']) && $request['is_local'] == true;
        $operator = Operator::find($request['operator']);
        if ($isLocal)
            $request->validate([    'local_amount' => 'required'    ]);
        else
            $request->validate([    'amount' => 'required'    ]);

        $amount =  $isLocal?($request['local_amount'] * (1 / $operator['fx_rate'])):($request['amount']);

        $number = $request['number'];

        if (!isset($user['user_role']))
            return response()->json(['errors' => [ 'error' => 'User Role not found.']],422);

        if(($user['user_role']['name'] == 'RESELLER') && ($user['balance_value'] < $amount))
                return response()->json( ['error' => 'Insufficient Balance for Transfer']);

        $invoice = new Invoice();
        $invoice['user_id'] = $user['id'];
        $invoice['amount'] = 0;
        $invoice['currency_code'] = $operator['sender_currency_code'];
        $invoice->save();

        $topup = Topup::create([
            'user_id' => $user['id'],
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

        if($user['user_role']['name'] == 'RESELLER') {
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
                return response()->json([
                    'location' => '/topups/history',
                    'message' => 'Payment Success. Redirecting now.'
                ]);
            }
        }
        else {
            System::updatePaymentIntent($invoice);
            System::sendEmail($user['email'], 'mails.invoices.created', ['invoice' => $invoice]);
        }
        return response()->json([
            'location' => '/invoices/view/'.$invoice['id'],
            'message' => 'Invoice Created. Proceeding to checkout'
        ]);
    }

    public function getFailedDetail($id){
        return view('dashboard.topups.failed',[
            'topup' => Topup::find($id)
        ]);
    }
}
