<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Operator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Models\System;
use App\Models\Country;

class OperatorsController extends Controller
{
    public function index()
    {
        return view('dashboard.reloadly.operators',[
            'page' => [
                'type' => 'dashboard'
            ],
            'operators' => Operator::all()
        ]);
    }

    public function promotions($id)
    {
        $operator = Operator::find($id);
        if (!isset($operator))
            return response()->json(['errors' => [ 'error' => 'Operator not found.']],422);
        return view('dashboard.promotions.operator_promotions', [
            'page' => [
                'type' => 'dashboard'
            ],
            'operator' => $operator,
            'promotions' => @$operator['promotions']
        ]);
    }

    public  function  sync(){
        Artisan::call('sync:operators');
        return response()->json([
            'message' => 'Sync Started for all Operators.',
            'location' => '/topups/operators'
        ]);
    }

    public function get($id, Request $request){
        $user = User::find($request->user()['id']);
        if(!$user)
            return response()->json(['errors' => ['error' => 'User not found.']],422);
        if (isset($user['user_role']) && ($user['user_role']['name'] == 'RESELLER')) {
            $operator = $user->api_operators()->where('id', $id)->first();
            $operator->makeHidden(['rid', 'international_discount', 'commission', 'local_discount']);
            unset($operator['rates']['user_id']);
            unset($operator['rates']['operator_id']);
            return response()->json($operator);
        }
        return response()->json(Operator::find($id));
    }
    public function detect($id,$number){
        return System::autoDetectOperator($number,Country::find($id)['iso'],-1);
    }
}
