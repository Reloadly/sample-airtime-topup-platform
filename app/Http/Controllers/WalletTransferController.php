<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\System;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class WalletTransferController extends Controller
{
    public function index(){
        return view('dashboard.wallet.transfer.home', [
            'page' => [
                'type' => 'dashboard'
            ],
            'currency' => @Setting::get('reloadly_currency')
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'user' => 'required',
            'amount' => 'required'
        ]);
        $user = User::find($request['user']);
        $me = Auth::user();
        if (!isset($user) || !isset($me))
            return response()->json(['errors' => ['error' => 'User Not Found']],422);
        $amount = doubleval($request['amount']);
        if ($amount <= 0)
            return response()->json(['errors' => ['error' => 'Amount should be greater than zero']],422);
        if ($me['id'] === $user['id'])
            return response()->json(['errors' => ['error' => 'Cannot transfer to self']],422);
        $fee = 0;
        $system = System::me();
        if (isset($me['user_role']) && ($me['user_role']['name'] !== "ADMIN") ){
            if ($me['balance_value'] < $amount)
                return response()->json(['errors' => ['error' => 'Insufficient Balance for Transfer']],422);
            if (!isset($me['stripe_response']['currency']))
                return response()->json(['errors' => ['error' => 'Invalid Currency for Wallet Found.']],422);
            $response = System::StripeTransferBalance($me,$amount,$me['stripe_response']['currency'],'Transferred to '.$user['username']);
            if (!$response)
                return response()->json(['errors' => ['error' => 'Transfer Failed. Unable to deduct from Wallet']],422);
            $fee = $user['user_role']['name'] === "CLIENT"?$system['wtw_customer_fee']:$system['wtw_reseller_fee'];
        }
        $meCurrency = Currency::where('code',$me['stripe_response']['currency'])->first();
        if (isset($user['stripe_response']['currency']))
            $currency = Currency::where('code',$user['stripe_response']['currency'])->first();
        else
            $currency = $meCurrency;

        $amount = $amount * (1 - ($fee / 100));
        if ($meCurrency['id'] !== $currency['id'])
            $amount = ($amount / $meCurrency['buy_rate']) * $currency['sell_rate'];
        $amount = round($amount,2);

        $response = System::StripeTransferBalance($user,-$amount,$currency['code'],'Received from '.$me['username']);
        if (!$response)
            return response()->json(['errors' => ['error' => 'Transfer Failed. Unable to send Transfer.']],422);
        return response()->json([
            'message' => 'Transfer Successful',
            'location' => 'transfer'
        ]);
    }
}
