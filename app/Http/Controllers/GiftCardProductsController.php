<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use App\Models\Country;
use App\Models\Currency;
use App\Models\GiftCardProduct;
use App\Models\GiftCardTransaction;
use App\Models\Invoice;
use App\Models\System;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class GiftCardProductsController extends Controller
{
    public function index(Request $request){
        if (!Auth::user()->hasPermission('READ'))
            return response()->json(['Errors' => ['Error' => 'Unauthorized Access.']],422);
        return view('dashboard.gift_cards.home',[
            'page' => [
                'type' => 'dashboard'
            ],
            'products' => GiftCardProduct::all()
        ]);
    }

    public function getGiftCardProducts(Request $request){
        $user = User::find($request->user()['id']);
        if(!$user) {
            return response()->json(['errors' => ['error' => 'User not found.']], 422);
        }
        $products = $user->gift_cards()->with('country')->get();
        $products->makeHidden(['rid','fixed_sender_denominations','sender_fee','fixed_denominations_map','pivot','country_id','discount_percentage','brand','created_at','updated_at','min_recipient_denomination','max_recipient_denomination','denomination_type','min_sender_denomination','max_sender_denomination','fixed_recipient_denominations']);
        return response()->json($products);
    }
    public function getGiftCardProductById(Request $request,$id){
        $user = User::find($request->user()['id']);
        if(!$user) {
            return response()->json(['errors' => ['error' => 'User not found.']], 422);
        }
        $products = $user->gift_cards()->with('country')->find($id);
        $products->makeHidden(['rid','fixed_sender_denominations','sender_fee','fixed_denominations_map','pivot','country_id','discount_percentage','brand','created_at','updated_at','min_recipient_denomination','max_recipient_denomination','denomination_type','min_sender_denomination','max_sender_denomination','fixed_recipient_denominations','fixed_sender_denominations']);
        return response()->json($products);
    }
    public function orderGiftCardProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'amount' => 'required',
            'recipient_email' => 'required',
            'ref' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['errors' => ['error' => 'product_id or amount or recipient_email or ref is missing.']],422);

        $transaction = GiftCardTransaction::where('reference',$request['ref'])->first();
        if ($transaction)
            return response()->json(['errors' => ['error' => 'Ref No is not unique.']],422);

        $user = User::find($request->user()['id']);
        if(!$user) {
            return response()->json(['errors' => ['error' => 'User not found.']], 422);
        }
        $product = $user->gift_cards()->with('country')->find($request['product_id']);
        if (!$product){
            return response()->json(['errors' => ['error' => 'Product not found.']], 422);
        }
        $paymentIndex = array_search($request['amount'], $product['amounts'], true);
        if (!$paymentIndex)
            return response()->json(['errors' => ['error' => 'Invalid Amount.']], 422);

        $senderCurrency = Currency::where('abbr', $product['sender_currency_code'])->first();
        if (!$senderCurrency)
            return response()->json(['errors' => ['Error' => 'Sender Currency not found!']],401);
        $recipientCurrency = Currency::where('abbr', $product['recipient_currency_code'])->first();
        if (!$recipientCurrency)
            return response()->json(['errors' => ['Error' => 'Recipient Currency not found!']],401);

        $amount = $product['fixed_denominations_map'][$paymentIndex] + $product['sender_fee'];
        if (isset($product['pivot']['discount']))
            $amount *= (1 - ($product['pivot']['discount']/100));
        $amount = round($amount,2);
        if($user['balance_value'] < $amount)
            return response()->json( ['errors' => ['error' => 'Insufficient Balance for Transfer']],422);

        $invoice = Invoice::create([
            'user_id' => $user['id'],
            'currency_code' => $product['sender_currency_code'],
            'amount' => $amount,
            'type' => 'GiftCard',
            'status' => 'PENDING'
        ]);

        $transaction = GiftCardTransaction::create([
            'user_id' => $user['id'],
            'email' => $request['recipient_email'],
            'invoice_id' => $invoice['id'],
            'product_id' => $product['id'],
            'product' => $product,
            'recipient_currency_id' => $recipientCurrency['id'],
            'sender_currency_id' => $senderCurrency['id'],
            'sender_amount' => $amount,
            'reloadly_fee' => $product['sender_fee'],
            'recipient_amount' => $paymentIndex,
            'reference' => isset($request['ref'])?$request['ref']:Str::random(10)
        ]);
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
            $transaction['status'] = 'PENDING';
            $transaction->save();
            return response()->json([
                'success' => [
                    'message' => 'Transaction created. It will be processed in a few minutes',
                    'transaction' => $transaction->makeHidden(['user_id','product','recipient_currency_id','sender_currency_id','reloadly_fee'])
                ]
            ]);
        }

        return response()->json([
            'errors' => ['error' => 'Transaction Failed to Debit Wallet']
        ],422);
    }

    public  function  sync(){
        Artisan::call('sync:gift_products');
        return response()->json([
            'message' => 'Sync Started for all Gift Cards.',
            'location' => '/gift_cards/gift_cards'
        ]);
    }

    public function products()
    {
        $countryIds = GiftCardProduct::pluck('country_id');
        $user = Auth::user();
        if ($user && $user['user_role_id'] === 3)
            $customerRate = Setting::get('customer_rate') ?: 0;
        else
            $customerRate = 0;
        return view('dashboard.gift_cards.wizard.home',[
            'page' => [
                'type' => 'dashboard'
            ],
            'countries' => Country::whereIn('id',$countryIds)->with('gifts')->orderBy('name')->get(),
            'token' => $user->createToken('Token')->accessToken,
            'customerRate' => $customerRate
        ]);
    }

    public function showGiftCard($id)
    {
        $user = Auth::user();
        if ($user && $user['user_role_id'] === 2)
            $giftCard = $user->gift_cards()->with('country')->find($id);
        else
            $giftCard = GiftCardProduct::with('country')->find($id);
        if (!$giftCard)
            return response()->json(['Errors' => ['Error' => 'Biller Not Found!']]);
        $user = Auth::user();
        if ($user && $user['user_role_id'] === 3)
            $customerRate = Setting::get('customer_rate') ?: 0;
        else
            $customerRate = 0;
        return view('dashboard.gift_cards.wizard.gift_Items',[
            'page' => [
                'type' => 'dashboard'
            ],
            'token' => $user->createToken('Token')->accessToken,
            'customerRate' => $customerRate,
            'gift_card' => $giftCard
        ]);
    }

    public function createInvoice(Request $request)
    {
        $request->validate([
            'payment_index' => 'required',
            'email' => 'required',
            'gift_id' => 'required',
            'amount' => 'required|gt:0'
        ]);
        $user = User::find(Auth::guard('api')->id());
        if ($user && $user['user_role_id'] === 3)
            $customerRate = Setting::get('customer_rate') ?: 0;
        else
            $customerRate = 0;
        $paymentIndex = $request['payment_index'];
        if ($user && $user['user_role_id'] === 2)
            $giftCard = $user->gift_cards()->find($request['gift_id']);
        else
            $giftCard = GiftCardProduct::find($request['gift_id']);
        if (!$giftCard)
            return response()->json(['errors' => ['Error' => 'Biller not found!']],401);
        $senderCurrency = Currency::where('abbr', $giftCard['sender_currency_code'])->first();
        if (!$senderCurrency)
            return response()->json(['errors' => ['Error' => 'Sender Currency not found!']],401);
        $recipientCurrency = Currency::where('abbr', $giftCard['recipient_currency_code'])->first();
        if (!$recipientCurrency)
            return response()->json(['errors' => ['Error' => 'Recipient Currency not found!']],401);

        $amount = $giftCard['fixed_sender_denominations'][$paymentIndex] + $giftCard['sender_fee'];

        $amount *= (1 + ($customerRate/100));
        if (isset($giftCard['pivot']['discount']))
            $amount *= (1 - ($giftCard['pivot']['discount']/100));
        $amount = round($amount,2);

        if(($user['user_role']['name'] === 'RESELLER') && ($user['balance_value'] < $amount))
            return response()->json( ['errors' => ['error' => 'Insufficient Balance for Transfer']],422);

        $invoice = Invoice::create([
            'user_id' => $user['id'],
            'currency_code' => $giftCard['sender_currency_code'],
            'amount' => $amount,
            'type' => 'GiftCard',
            'status' => 'PENDING'
        ]);

        $transaction = GiftCardTransaction::create([
            'user_id' => $user['id'],
            'email' => $request['email'],
            'invoice_id' => $invoice['id'],
            'product_id' => $giftCard['id'],
            'product' => $giftCard,
            'recipient_currency_id' => $recipientCurrency['id'],
            'sender_currency_id' => $senderCurrency['id'],
            'sender_amount' => $amount,
            'reloadly_fee' => $giftCard['sender_fee'],
            'recipient_amount' => $giftCard['fixed_recipient_denominations'][$paymentIndex],
            'reference' => Str::random(10),
        ]);

        if($user['user_role']['name'] === 'RESELLER') {
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
                $transaction['status'] = 'PENDING';
                $transaction->save();
                return response()->json([
                    'location' => '/gift_cards/history',
                    'message' => 'Payment Success. Redirecting now.'
                ]);
            }
        }
        else {
            System::updatePaymentIntent($invoice);
            System::sendEmail($user['email'], 'mails.invoices.created', ['invoice' => $invoice]);
        }

        return response()->json([
            'message' => 'Invoice Saved Successfully',
            'invoice_id' => $invoice['id'],
        ]);
    }
}
