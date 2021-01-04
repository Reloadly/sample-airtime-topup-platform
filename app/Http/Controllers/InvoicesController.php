<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use App\Models\Invoice;
use App\Models\System;
use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        if(!(isset($user) || !isset($user['user_role'])))
            return response()->json(['errors' => ['error' => 'User or User Role Not Found.']],422);
        return view('dashboard.invoices.home', [
            'page' => [
                'type' => 'dashboard'
            ],
            'invoices' => $user['user_role']['name'] == 'ADMIN' ? Invoice::all() : $user['invoices']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'amount' => 'required',
            'status' => 'required'
        ]);
        $invoice = Invoice::find($request['id']);
        if ($invoice === null)
            return response()->json(['errors' => ['error' => 'Not Authorized to perform such action.']],422);
        $invoice['amount'] = $request['amount'];
        $invoice['status'] = $request['status'];
        $invoice->save();
        return response()->json([
            'location' => '/invoices',
            'message' => 'Invoice Saved. Redirecting Now'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Object
     */
    public function show($id)
    {
        $user = Auth::user();
        $invoice = Invoice::find($id);
        if ($invoice === null )
            return response()->json(['errors' => ['error' => 'Invoice Not Found.']],422);
        if(!(isset($user) && isset($user['user_role']) && ($user['user_role']['name'] == 'ADMIN')))
            return response()->json(['errors' => ['error' => 'Not Authorized to perform such action.']],422);
        return view('dashboard.invoices.modal',[
            'item' => $invoice
        ]);
    }

    public function getTopupsForInvoice($id){
        return view('dashboard.invoices.topups',[
            'invoice' => Invoice::find($id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Object
     */
    public function view($id)
    {
        $user = Auth::user();
        $invoice = Invoice::find($id);
        if ($invoice === null )
            return response()->json(['errors' => ['error' => 'Invoice Not Found.']],422);
        if(!(isset($user) || !isset($user['user_role'])))
            return response()->json(['errors' => ['error' => 'User or User Role Not Found.']],422);
        if (($user['user_role']['name'] !== 'ADMIN' && $user['id'] !== $invoice['user_id']))
            return response()->json(['errors' => ['error' => 'Not Authorized to perform such action.']],422);
        return view('dashboard.invoices.view',[
            'page' => [
                'type' => 'dashboard'
            ],
            'invoice' => Invoice::find($id)
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Auth::user()['user_role']['name'] !== 'ADMIN')
            return response()->json(['errors' => ['error' => 'Not Authorized to perform such action.']],422);
        Invoice::find($id)->delete();
    }

    public function stripeCheckout($id, Request $request){
        $invoice = Invoice::find($id);
        $user = Auth::user();
        if ($invoice === null)  return response()->json(['errors' => ['error' => 'Invoice not found']],422);
        if ($invoice['user_id'] !== $user['id'])    return response()->json(['errors' => ['error' => 'Unauthorized Action']],422);
        System::updatePaymentIntent($invoice);
        if ($invoice['status'] === 'PAID')
            return response()->json(['errors' => ['error' => 'Invoice Already Paid. Please refresh page to continue.']],422);
        if (isset($invoice['payment_intent_response']['Error']) && !empty($invoice['payment_intent_response']['Error']))
            return response()->json(['errors' => $invoice['payment_intent_response']],422);
        return view('dashboard.stripe.checkout_modal',['invoice' => $invoice]);
    }

    public  function stripeResponse(Request $request){
        $invoice = Invoice::where('payment_intent_id',$request['id'])->first();
        if ($invoice === null)
            return response()->json(['errors' => [
                'error' => 'System Failed to process Invoice.',
                'todo' => 'Contact Support with your invoice Id'
            ]],422);
        System::updatePaymentIntent($invoice);
        return response()->json([
            'location' => '/invoices/view/'.$invoice['id'],
            'message' => 'Invoice Updated. Redirecting now.'
        ]);
    }

    public function PaypalCheckout($id){
        $invoice = Invoice::find($id);
        if ($invoice === null)
            return response()->json(['errors' => ['error' => 'Invoice Not Found']],422);
        else
        {
            System::updatePaypalOrder($invoice);
            if ($invoice['status'] === 'PAID' || $invoice['status'] === 'PROCESSING')
                return response()->json(['errors' => ['error' => 'Invoice Already Paid. Please refresh page to continue.']],422);
            return response()->json([ 'order_id' => $invoice['paypal_order_id'] ]);
        }
    }
    public  function paypalResponse($id, Request $request){
        $invoice = Invoice::find($id);
        if ($invoice === null)
            return response()->json(['errors' => ['error' => 'Invoice Not Found']],422);
        else
            System::updatePaypalOrder($invoice);
        return response()->json(['status' => 'success']);
    }

    public function markInvoicePaid($id){
        $invoice = Invoice::find($id);
        if(!$invoice)
            return response()->json(['errors' => ['error' => 'Topup not found.']],422);
        if (Auth::user()['user_role']['name'] !== 'ADMIN')
            return response()->json(['errors' => ['error' => 'Not Authorized to perform such action.']],422);
        $invoice['status'] = 'PAID';
        $invoice->save();
        return response()->json([
            'location' => '/invoices',
            'message' => 'Invoice marked Paid. Redirecting Now'
        ]);
    }

    public function balanceCheckout($id){
        if (Auth::user()['user_role']['name'] == 'CUSTOMER')
            return response()->json(['errors' => ['error' => 'Not Authorized to perform such action.']],422);
        $invoice = Invoice::find($id);
        $user = Auth::user();
        if ($invoice === null || $invoice['user_id'] !== $user['id'])
            return response()->json(['errors' => ['error' => 'Invoice Not Found']],422);
        if ($invoice['type'] == 'AddFunds')
            return response()->json(['errors' => ['error' => 'Not Authorized to pay with balance for this invoice type.']],422);
        if ($user['balance_value'] < $invoice['amount'])
            return response()->json(['errors' => ['error' => 'Balance too low for this payment']],422);
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
            if($invoice['type'] == 'Topup') {
                $ids = $invoice->topups()->pluck('id');
                Topup::whereIn('id', $ids)->where('status', 'PENDING_PAYMENT')->update([
                    'status' => 'PENDING'
                ]);
            }
            return response()->json([
                'location' => '/invoices/view/' . $invoice['id'],
                'message' => 'Invoice Updated. Redirecting now.'
            ]);
        }else
            return response()->json(['errors' => ['error' => 'Something went wrong']],422);

    }

    public function print($id)
    {
        $invoice = Invoice::find($id);
        if ($invoice === null || (Auth::user()['user_role']['name'] !== 'ADMIN' && Auth::user()['id'] !== $invoice['user_id']))
            return response()->json(['errors' => ['error' => 'Not Authorized to perform such action.']],422);
        return view('dashboard.invoices.print',[

            'invoice' => $invoice
        ]);
    }
}
