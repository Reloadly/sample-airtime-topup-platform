<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use App\Models\Country;
use App\Models\File;
use App\Models\FileEntry;
use App\Models\Invoice;
use App\Models\Operator;
use App\Models\System;
use App\Models\Timezone;
use App\Models\Topup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class WizardController extends Controller
{
    public function index(){
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        return view('dashboard.wizard.home', [
            'page' => [
                'type' => 'dashboard'
            ],
            'files' => $user['files']
        ]);
    }

    public function getTemplate(){
        return view('dashboard.wizard.template');
    }

    public function getOperators($id){
        $fileEntry = FileEntry::find($id);
        if ($fileEntry === null)
            return response()->json(['errors' => ['error' => 'File Entry not found']],422);
        return response()->json(Operator::where('country_id', $fileEntry['country_id'])->get());
    }

    public function start ($id){
        $file = File::find($id);
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        $token = $user->createToken('Token')->accessToken;
        if ($file === null)
            return response()->json(['errors' => ['error' => 'File not found']],422);
        if ($file['user_id'] !== $user['id'])
            return response()->json(['errors' => ['error' => 'Unauthorized Access']],422);
        return view('dashboard.wizard.confirm',[
            'page'=>['type' => 'dashboard'],
            'countries' => Country::all(),
            'file' => $file,
            'token' => $token
        ]);
    }

    public function schedule($id){
        $file = File::find($id);
        if ($file === null)
            return response()->json(['errors' => ['error' => 'File not found']],422);
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        if ($file['user_id'] !== $user['id'])
            return response()->json(['errors' => ['error' => 'Unauthorized Access']],422);
        if ($file['status'] === 'START')
            return view('dashboard.wizard.schedule',[
                'page'=>['type' => 'dashboard'],
                'file' => $file,
                'timezones' => Timezone::all()
            ]);
        else
            return redirect('/topups/bulk');
    }

    public function scheduleTopup($id, Request $request){
        $file = File::find($id);
        if ($file === null)
            return response()->json(['errors' => ['error' => 'File not found']],422);
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        if ($file['user_id'] !== $user['id'])
            return response()->json(['errors' => ['error' => 'Unauthorized Access']],422);
        if ((isset($request['schedule_now'])) && $request['schedule_now'] == 'true'){
            $timezone = Timezone::where('abbr','UTC')->first();
            $now = Carbon::now($timezone['utc'][0]);
            $dateTime = $now;
        }else {
            $request->validate([
                'timezone' => 'required',
                'date' => 'required',
                'time' => 'required'
            ]);
            $timezone = Timezone::find($request['timezone']);
            $dateTime = Carbon::parse($request['date'].' '.$request['time'], $timezone['utc'][0]);
            $now = Carbon::now($timezone['utc'][0]);
        }
        if ($timezone === null)
            return response()->json(['errors' => ['error' => 'Timezone not found']],422);
        if ($dateTime < $now)
            return response()->json(['errors' => ['error' => 'You cannot schedule in the past.']],422);
        if ($file['status'] !== 'START')
            return response()->json(['errors' => ['error' => 'File Already Processed']],422);
        foreach ($file['numbers'] as $number) {
            $operator = Operator::find($number['operator_id']);
            $invoice = new Invoice();
            $invoice['user_id'] = $user['id'];
            $invoice['amount'] = 0;
            $invoice['currency_code'] = $operator['sender_currency_code'];
            $invoice->save();

            $amount =  $number['is_local']?($number['amount'] * (1 / $operator['fx_rate'])):($number['amount']);

            $topup = Topup::create([
                'user_id' => $user['id'],
                'file_entry_id' => $number['id'],
                'timezone_id' => $timezone['id'],
                'scheduled_datetime' => $dateTime,
                'operator_id' => $operator['id'],
                'invoice_id' => $invoice['id'],
                'topup' => $number['is_local']?
                    $number['amount']:
                    ($operator['fx_rate'] * $number['amount']),
                'amount' => $number['is_local']?
                    ($number['amount'] * (1 / $operator['fx_rate']))
                    :
                    ($number['amount']),
                'number' => $number['number'],
                'sender_currency' => $operator['sender_currency_code'],
                'receiver_currency' => $operator['destination_currency_code'],
                'is_local' => $number['is_local']
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
                $ids = $invoice->topups()->pluck('id');
                Topup::whereIn('id', $ids)->where('status', 'PENDING_PAYMENT')->update([
                    'status' => 'PENDING'
                ]);
            }

        }
        $file['status'] = 'DONE';
        $file->save();
        return response()->json([
            'message' => 'File Scheduled.',
            'location' => '/topups/history'
        ]);
    }

    public function process($id, Request $request){
        $request->validate([
            'id' => 'required|array',
            'id.*' => 'required|distinct',
            'country' => 'required|array',
            'operator' => 'required|array',
            'is_local' => 'required|array',
            'is_local.*' => 'required|min:0|max:1',
            'amount' => 'required|array',
            'amount.*' => 'required',
            'number' => 'required|array',
            'number.*' => 'required'
        ],[
            'amount.*.required'=> 'Amount is Required',
            'is_local.*.min'=> 'Data seems to be corrupt. Please refresh page.',
            'is_local.*.max'=> 'Data seems to be corrupt. Please refresh page.',
        ]);
        $user = Auth::user();
        $file = File::find($id);
        if ($file === null)
            return response()->json(['errors' => ['error' => 'Invalid Request File.']],422);
        foreach ($request['id'] as $key => $id){
            $fileEntry = FileEntry::find($id);
            if ($fileEntry === null)
                return response()->json(['errors' => ['error' => 'Invalid Entry in Stack.']],422);
            $request->validate([
                'country.'.$key => 'required|int|min:1',
                'operator.'.$key => 'required|int|min:1',
                'is_local.'.$key => 'required|int|min:0|max:1',
                'amount.'.$key => 'required',
            ],[
                'country.*.min'=> 'Invalid Country Selected for Entry at '.($key+1),
                'operator.*.min'=> 'Invalid Operator Selected for Entry at '.($key+1),
            ]);
            $country = Country::find($request['country'][$key]);
            $operator = Operator::find($request['operator'][$key]);
            $isLocal = $request['is_local'][$key] == '1';
            $amount = $request['amount'][$key];
            $number = $request['number'][$key];
            if ($country)
                if ($operator && $operator['country_id'] === $country['id'])
                    if (!($isLocal && !$operator['supports_local_amounts']))
                        switch ($operator['denomination_type']) {
                            case 'FIXED':
                                if ($operator['supports_geographical_recharge_plans']){
                                    $zoneAmountExist = false;
                                    foreach ($operator['geographical_recharge_plans'] as $zone){
                                        $amounts = $zone['fixedAmounts'];
                                        $element = in_array($amount, $amounts);
                                        if ($element)
                                        {
                                            FileEntry::whereId($fileEntry['id'])->update([
                                                'country_id' => $country['id'],
                                                'operator_id' => $operator['id'],
                                                'is_local' => false,
                                                'amount' => $amount,
                                                'number' => $number
                                            ]);
                                            $zoneAmountExist = true;
                                            break;
                                        }
                                    }
                                    if (!$zoneAmountExist)
                                        return response()->json(['errors' => ['error' => 'INVALID AMOUNT']],422);
                                }else{
                                    $amounts = $operator['fixed_amounts'];
                                    if ($isLocal)
                                        $amounts = $operator['local_fixed_amounts'];
                                    $element = in_array($amount, $amounts);
                                    if ($element)
                                    {
                                        FileEntry::whereId($fileEntry['id'])->update([
                                            'country_id' => $country['id'],
                                            'operator_id' => $operator['id'],
                                            'is_local' => $isLocal,
                                            'amount' => $amount,
                                            'number' => $number
                                        ]);
                                    }
                                    else
                                        return response()->json(['errors' => ['error' => 'INVALID AMOUNT']],422);
                                }
                                break;
                            case 'RANGE':
                                $min = $operator['min_amount'];
                                $max = $operator['max_amount'];
                                    if ($isLocal){
                                        $min = $operator['local_min_amount'];
                                        $max = $operator['local_max_amount'];
                                    }
                                    if ($amount >= $min)
                                        if ($amount <= $max)
                                        {
                                            FileEntry::whereId($fileEntry['id'])->update([
                                                'country_id' => $country['id'],
                                                'operator_id' => $operator['id'],
                                                'is_local' => $isLocal,
                                                'amount' => $amount,
                                                'number' => $number
                                            ]);
                                        }
                                        else
                                            return response()->json(['errors' => ['error' => 'AMOUNT < '.$max]],422);
                                    else
                                        return response()->json(['errors' => ['error' => 'AMOUNT > '.$min]],422);
                                    break;
                            default:
                                return response()->json(['errors' => ['error' => 'INVALID OPERATOR TYPE']],422);
                        }
                    else
                        return response()->json(['errors' => ['error' => 'OPERATOR DOES NOT SUPPORT LOCAL']],422);
                else
                    return response()->json(['errors' => ['error' => 'INVALID OPERATOR']],422);
            else
                return response()->json(['errors' => ['error' => 'INVALID COUNTRY']],422);
        }
        $balance = Auth::user()['balance_value'];
        $total = $file['total_amount'];
        if ($total <= $balance)
            return response()->json([
                'message' => 'All Entries Saved. Proceeding to Next Step',
                'location' => '/topups/bulk/wizard/schedule/file/'.$file['id']
            ]);
        else
            return response()->json(['errors' => [
                'Error' => 'Insufficient Balance<br><br>Required '.$total.' '.@Setting::get('reloadly_currency').'<br>Available '.$balance
            ]],422);
    }

    public function deleteEntry($id){
        $fileEntry = FileEntry::find($id);
        if (!isset($fileEntry))
            return response()->json(['errors' => [ 'error' => 'File Entry not found.']],422);
        $fileEntry->delete();
        return response()->json(['message' => 'Successfully Deleted']);
    }
}
