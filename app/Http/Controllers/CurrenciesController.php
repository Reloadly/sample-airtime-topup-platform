<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CurrenciesController extends Controller
{
    public  function getAll(){
        return response()->json(Currency::all());
    }
}
