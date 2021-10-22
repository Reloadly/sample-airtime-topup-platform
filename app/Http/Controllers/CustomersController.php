<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\GoogleAuthenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OTIFSolutions\ACLMenu\Models\UserRole;

class CustomersController extends Controller
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
                'url' => '/users/customers',
                'icon' => 'feather icon-users',
                'name' => 'Customers'
            ],
            'users' => User::where('user_role_id',UserRole::where('name','CUSTOMER')->first()['id'])->get(),
            'manage_rates' => false
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
            $user['phone'] = $request['phone'];
            $user['username'] = $request['username'];
            $user['2fa_secret'] = GoogleAuthenticator::Make()->createSecret();
        }
        $user['name'] = $request['name'];
        $user['user_role_id'] = UserRole::where('name','CUSTOMER')->first()['id'];
        if (isset($request['password']) && !empty($request['password']))
            $user['password'] = Hash::make($request['password']);
        $user->save();
        return response()->json([
            'location' => '/users/customers',
            'message' => 'User Saved. Redirecting Now'
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
            'url' => '/users/customers',
            'name' => 'Customer',
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
}
