<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OTIFSolutions\ACLMenu\Models\UserRole;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class WalletController extends Controller
{
    public function index(){
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        return view('dashboard.wallet.account.home', [
            'page' => [
                'type' => 'dashboard'
            ],
            'accountTransactions' => $user['account_transactions']
        ]);
    }

    public function wallets(){
        return view('dashboard.wallet.wallets', [
            'page' => [
                'type' => 'dashboard'
            ],
            'resellers' => User::where('user_role_id', UserRole::where('name', 'RESELLER')->first()['id'])->get()
        ]);
    }

    public function show(){
        return view('dashboard.wallet.account.invoice',[
            'currency' => @Setting::get('reloadly_currency')
        ]);
    }

    public function showModal($id){
        $reseller = User::find($id);
        if (!$reseller)
            return response()->json(['errors' => ['error' => 'Reseller not found']],422);
        return view('dashboard.wallet.add_balance',[
            'currency' => @Setting::get('reloadly_currency'),
            'reseller' => $reseller
        ]);
    }

    public function transactions(){
        return view('dashboard.wallet.transactions', [
            'page' => [
                'type' => 'dashboard'
            ],
            'accountTransactions' => AccountTransaction::all()
        ]);
    }

    public function create(Request $request){
        $request->validate([
            'amount' => 'required',
            'currency' => 'required'
        ]);
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        if ($request['amount'] < 5)
            return response()->json(['errors' => ['error' => 'Minimum Amount is 5.00']],422);

        $invoice = Invoice::create([
            'user_id' => $user['id'],
            'type' => 'AddFunds',
            'currency_code' => $request['currency'],
            'amount' => $request['amount']
        ]);
        return response()->json([
            'message' => 'Invoice Created. Redirecting Now.',
            'location' => '/invoices/view/'.$invoice['id']
        ]);
    }

    public function storeBalance(Request $request){
        $request->validate([
            'amount' => 'required',
            'currency' => 'required'
        ]);
        if ($request['amount'] <= 0)
            return response()->json(['errors' => ['error' => 'Amount should be greater than zero']],422);
        $reseller = User::find($request['reseller_id']);
        if (!$reseller)
            return response()->json(['errors' => ['error' => 'Reseller not found']],422);

        $transaction = new AccountTransaction();
        $transaction['user_id'] = $reseller['id'];
        $transaction['amount'] = $request['amount'];
        $transaction['currency'] = $request['currency'];
        $transaction['type'] = 'CREDIT';
        $transaction['description'] = 'Funds Added by Admin: '.Auth::user()['id'];
        $transaction['ending_balance'] = $reseller['balance_value'] + $request['amount'];
        $transaction->save();

        return response()->json([
            'message' => 'Funds Added. Redirecting Now.',
            'location' => '/wallet/accounts/'
        ]);
    }
}
