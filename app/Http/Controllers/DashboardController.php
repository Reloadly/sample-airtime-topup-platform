<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Operator;
use App\Models\Topup;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $admin = User::admin();
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        if (isset($user['user_role']) && ($user['user_role']['name'] == 'ADMIN'))
            return view('dashboard.dashboard', [
                'page' => [
                    'type' => 'dashboard'
                ],
                'stats' => [
                    'balance' => $admin->getBalance(),
                    'countries' => Country::all()->count(),
                    'operators' => Operator::all()->count(),
                    'topups' => Topup::all()->count(),
                    'users' => User::all()->count(),
                    'invoices' => Invoice::where('status','PAID')->count(),
                    'topups_total' => Topup::all()->sum('amount')
                ]
            ]);
        else
            return view('dashboard.dashboard', [
                'page' => [
                    'type' => 'dashboard'
                ],
                'stats' => [
                    'countries' => Country::all(),
                    'operators' => Operator::all()->count(),
                    'topups' => Auth::user()->topups()->count(),
                    'invoices' => Auth::user()->invoices()->count(),
                    'cards' => Auth::user()->stripe_payment_methods()->count(),
                    'topups_total' => Auth::user()->topups()->sum('amount'),
                    'token' => Auth::user()->createToken('Token')->accessToken,
                    'send'=>true
                ]
            ]);
    }

    public  function statsTopupAmount(){
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        if (isset($user['user_role']) && ($user['user_role']['name'] == 'ADMIN'))
            $topups = Topup::all()->pluck('amount')->toArray();
        else
            $topups = Auth::user()->topups()->pluck('amount')->toArray();
        return response()->json(array_map(function($num){return number_format($num,2);}, $topups));
    }


}
