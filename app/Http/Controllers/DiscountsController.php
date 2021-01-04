<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class DiscountsController extends Controller
{
    public  function index(){
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        if(isset($user['user_role']) && ($user['user_role']['name'] == 'ADMIN'))
            $discounts = Discount::all();
        else
            $discounts = $user->operators()->get();
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
