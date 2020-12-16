<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DiscountsController extends Controller
{
    public  function index(){
        if(auth()->user()['user_role']['name'] == 'ADMIN')
            $discounts = Discount::all();
        else
            $discounts = auth()->user()->operators()->get();
        return view('dashboard.reloadly.discounts',[
            'page' => [
                'type' => 'dashboard'
            ],
            'discounts' => $discounts
        ]);
    }
    public  function  sync(){
        Artisan::call('sync:discounts');
        return response()->json([
            'message' => 'Sync Started for all Discounts.',
            'location' => '/topups/discounts'
        ]);
    }

}
