<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PromotionsController extends Controller
{
    public  function index(){
        return view('dashboard.promotions.home',[
            'page' => [
                'type' => 'dashboard'
            ],
            'promotions' => Promotion::all()
        ]);
    }
    public  function  sync(){
        Artisan::call('sync:promotions');
        return response()->json([
            'message' => 'Sync Started for all Promotions.',
            'location' => '/topups/promotions'
        ]);
    }
    public function show($id){
        return view('dashboard.promotions.modal',[
            'item' => Promotion::find($id)
        ]);
    }
}
