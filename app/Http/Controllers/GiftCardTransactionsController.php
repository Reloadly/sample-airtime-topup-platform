<?php

namespace App\Http\Controllers;

use App\Models\GiftCardTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GiftCardTransactionsController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.gift_cards.history.home',[
            'page' => [
                'type' => 'dashboard'
            ],
            'transactions' => Auth::user()['user_role_id'] === 1 ?
                GiftCardTransaction::all() :
                GiftCardTransaction::where('user_id',Auth::user()['id'])->get()
        ]);
    }

    public function getFailedDetail($id){
        if (!Auth::user()->hasPermission('READ'))
            return response()->json(['errors' => ['error' => 'Unauthorized Access.']],422);
        return view('dashboard.gift_cards.history.failed',[
            'transaction' => GiftCardTransaction::find($id)
        ]);
    }

    public function getSuccessDetail($id){
        if (!Auth::user()->hasPermission('READ'))
            return response()->json(['errors' => ['error' => 'Unauthorized Access.']],422);
        return view('dashboard.gift_cards.history.redeem',[
            'transaction' => GiftCardTransaction::find($id)
        ]);
    }
}
