<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['errors' => ['error' => 'Unauthorized Access']],422);
        $topups = $user['topups'];
        $topups->makeHidden(['user_id','file_entry_id','response']);
        return response()->json($topups);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $ref
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByRef($ref)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['errors' => ['error' => 'Unauthorized Access']],422);
        $topups = $user->topups()->where('ref_no',$ref)->first();
        if (!$topups)
            return response()->json(['errors' => ['error' => 'Transaction Not Found.']],422);
        $topups->makeHidden(['user_id','file_entry_id','response']);
        return response()->json($topups);
    }
    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showById($id)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['errors' => ['error' => 'Unauthorized Access']],422);
        $topups = $user->topups()->Where('id',$id)->first();
        if (!$topups)
            return response()->json(['errors' => ['error' => 'Transaction Not Found.']],422);
        $topups->makeHidden(['user_id','file_entry_id','response']);
        return response()->json($topups);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
