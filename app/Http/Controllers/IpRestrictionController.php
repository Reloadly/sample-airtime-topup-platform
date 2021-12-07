<?php

namespace App\Http\Controllers;

use App\Models\IpAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IpRestrictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['errors' => ['error' => 'Authentication Failed']],422);
        return view('dashboard.ips.home', [
            'page' => [
                'type' => 'dashboard'
            ],
            'ips' => $user['ips']
        ]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'ip' => 'required'
        ]);
        $user = Auth::user();
        if (!$user)
            return response()->json(['errors' => ['error' => 'Authentication Failed']],422);
        $ip = $user->ips()->find($request['id']);
        if ($ip === null){
            $ip = new IpAddress();
            $ip['user_id'] = $user['id'];
        }
        $ip['ip'] = $request['ip'];
        $ip->save();

        return response()->json([
            'location' => '/ip_restriction',
            'message' => 'User Saved. Redirecting Now'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        return view('dashboard.ips.modal',[
            'item' => IpAddress::find($id)
        ]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['errors' => ['error' => 'Authentication Failed']],422);

        $ip = $user->ips()->find($id);
        if (!$ip)
            return response()->json(['errors' => [ 'error' => 'IP not found.']],422);
        $ip->delete();
    }

    public function changeStatus(Request $request){
        $user = Auth::user();
        if (!$user)
            return response()->json(['errors' => ['error' => 'Authentication Failed']],422);
        $user['ip_restriction'] = $user['ip_restriction']==='ENABLED'?'DISABLED':'ENABLED';
        $user->save();
        return response()->json([
            'message' => 'Status Updated.',
            'location' => '/ip_restriction'
        ]);
    }
}
