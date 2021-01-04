<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Artisan;

class CountriesController extends Controller
{

    public function index()
    {
        return view('dashboard.reloadly.countries',[
            'page' => [
                'type' => 'dashboard'
            ],
            'countries' => Country::all()
        ]);
    }

    public function operators($id)
    {
        $country = Country::find($id);

        return view('dashboard.reloadly.country_operators', [
            'page' => [
                'type' => 'dashboard'
            ],
            'country' => $country,
            'operators' => $country['operators']
        ]);
    }

    public  function  sync(){
        Artisan::call('sync:countries');
        return response()->json([
            'message' => 'Sync Started for all Countries.',
            'location' => '/topups/countries'
        ]);
    }

    public function getOperatorsForCountry($id, Request $request)
    {
        $user = User::find($request->user()['id']);
        if (!$user)
            return response()->json(['errors' => ['error' => 'User not found.']], 422);
        if (isset($user['user_role']) && ($user['user_role']['name'] == 'RESELLER')){
            $operators = $user->api_operators()->where('country_id', $id)->get();
            $operators->makeHidden(['rid', 'international_discount', 'commission', 'local_discount']);
            foreach ($operators as $key => $operator) {
                if(isset($operator['rates'])) {
                    unset($operator['rates']['user_id']);
                    unset($operator['rates']['operator_id']);
                }
                $operators[$key] = $operator;
            }
            return response()->json($operators);
        }
        return response()->json(Country::find($id)['operators']);
    }

    public function getAll(){
        return response()->json(Country::all());
    }


}
