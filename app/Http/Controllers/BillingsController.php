<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\StripePaymentMethod;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.billings.home',[
            'page' => [
                'type' => 'dashboard'
            ],
            'cards' => Auth::user()['stripe_payment_methods']
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sync()
    {
        $user = Auth::user();
        System::updatePaymentMethods($user);
        return response()->json([
            'message' => 'Payment Methods Synced. Redirecting now.',
            'location' => '/billings'
        ]);
    }

    public function show()
    {
        $intent = System::createSetupIntent(Auth::user());
        if (!$intent) return;
        return view('dashboard.stripe.add_card_modal',[
            'intent' => $intent
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
        $card = StripePaymentMethod::find($id);
        if ($card !== null && $card['user_id'] !== Auth::user()['id'])
            return response()->json(['errors' => ['error' => 'Not Authorized to perform such action.']],422);
        System::removePaymentMethod($card);
    }

}
