<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDocController extends Controller
{
    public  function index(){
        return view('dashboard.api_doc.home',[
            'page' => [
                'type' => 'dashboard'
            ]
        ]);
    }
}
