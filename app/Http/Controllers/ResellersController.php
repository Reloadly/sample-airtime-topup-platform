<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\User;
use App\Traits\GoogleAuthenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OTIFSolutions\ACLMenu\Models\UserRole;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class ResellersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.users.home', [
            'page' => [
                'type' => 'dashboard',
                'url' => '/users/resellers',
                'icon' => 'feather icon-users',
                'name' => 'Resellers'
            ],
            'users' => User::where('user_role_id',UserRole::where('name','RESELLER')->first()['id'])->get(),
            'manage_rates' => true
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
           'name' => 'required',
           'password' => 'required_with:confirm_password|same:confirm_password'
        ]);
        $user = User::find($request['id']);
        if ($user === null){
            $user = new User();
            $request->validate([
                'password' => 'required',
                'email' => 'required|unique:users',
                'phone' => 'required|unique:users',
                'username' => 'required|unique:users',
            ]);
            $user['email'] = $request['email'];
            $user['username'] = $request['username'];
            $user['phone'] = $request['phone'];
            $user['2fa_secret'] = GoogleAuthenticator::Make()->createSecret();
        }
        $user['name'] = $request['name'];
        $user['user_role_id'] = UserRole::where('name','RESELLER')->first()['id'];
        if (isset($request['password']) && !empty($request['password']))
            $user['password'] = Hash::make($request['password']);
        $user->save();

        if(!count($user['operators'])){
            $operators = Operator::all();
            $user->operators()->sync($operators->pluck('id'));
            $userOperators = $user->operators()->get();
            foreach ($userOperators as $operator){
                $operator->pivot->international_discount = $operator['discount']['international_percentage'] * (Setting::get('reseller_discount') / 100);
                $operator->pivot->local_discount = $operator['discount']['local_percentage'] * (Setting::get('reseller_discount') / 100);
                $operator->pivot->save();
            }
        }

        return response()->json([
            'location' => '/users/resellers',
            'message' => 'User Saved. Redirecting Now'
        ]);
    }

    public function showResellerRates($id)
    {
        $reseller = User::find($id);
        if(!isset($reseller))
            return response()->json(['errors' => ['error' => 'Reseller not found.']],422);
        return view('dashboard.users.reseller_rates', [
            'page' => [
                'type' => 'dashboard',
                'url' => '/users/resellers',
                'icon' => 'feather icon-users',
                'name' => 'Reseller Rates'
            ],
            'operators' => $reseller['operators'],
            'reseller' => $reseller
        ]);
    }

    public function saveResellerRates($id, Request $request){
        $request->validate([
            'id' => 'required',
            'local_discount' => 'required|array',
            'international_discount' => 'required|array'
        ]);
        $user = User::where('id',$request['id'])->first();
        if (!isset($user) || !isset($user['user_role']))
            return response()->json(['errors' => [ 'error' => 'User or User Role not found.']],422);
        if($user['user_role']['name'] != 'RESELLER')
            return response()->json(['errors' => ['error' => 'Applicable for Resellers Only']],422);
        if (!$user)
            return response()->json(['errors' => ['error' => 'User Not Found']],422);

        foreach ($request['operator_id'] as $key => $operatorId)
        {
            $operator =  $user->operators()->where('operator_id',$operatorId)->first();
            $operator->pivot->local_discount = $request['local_discount'][$key];
            $operator->pivot->international_discount = $request['international_discount'][$key];
            $operator->pivot->save();
        }
        return response()->json([
            'message' => 'Rates Saved.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        return view('dashboard.users.modal',[
            'item' => User::find($id),
            'url' => '/users/resellers',
            'name' => 'Reseller',
            'icon' => 'feather icon-users'
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        $user->operators()->sync([]);
        /*$user->topups()->delete();
        $user->invoices()->delete();
        $user->numbers()->delete();
        $user->stripe_payment_methods()->delete();
        $system = User::admin();
        foreach ($user['virtual_cards'] as $card){
            $system->FWSyncCards($card);
            $system->FWWithdrawCard($card,$card['amount']);
            $system->FWTerminateCard($card);
            $card->transactions()->delete();
            $card->delete();
        }*/
        $user->delete();
    }

    public function changeTFAStatus($id){
        $user = User::find($id);
        if(!$user)
            return response()->json(['errors' => ['error' => "Sorry! User not found."]],422);

        $user['2fa_mode'] = $user['2fa_mode']==='ENABLED'?'DISABLED':'ENABLED';
        $user->save();
        return response()->json([
            'message' => 'Status Updated.',
            'refresh' => true
        ]);
    }

    public function changeIPRStatus($id){
        $user = User::find($id);
        if(!$user)
            return response()->json(['errors' => ['error' => "Sorry! User not found."]],422);

        $user['ip_restriction'] = $user['ip_restriction']==='ENABLED'?'DISABLED':'ENABLED';
        $user->save();
        return response()->json([
            'message' => 'Status Updated.',
            'refresh' => true
        ]);
    }
}
