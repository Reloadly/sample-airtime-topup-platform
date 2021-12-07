<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\GoogleAuthenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user && !$user['2fa_secret'])
        {
            $user['2fa_secret'] = GoogleAuthenticator::Make()->createSecret();
            $user->save();
        }
        return view('dashboard.profile',[
            'page' => [
                'type' => 'dashboard'
            ]
        ]);
    }

    public function uploadProfileImage(Request $request){
        $request->validate([
            'avatar' => 'required|file'
        ]);

        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        $user['image'] = Str::random(32).'.'.\File::extension($request['avatar']->getClientOriginalName());
        $request['avatar']->storeAs("public",$user['image']);
        $user['image'] = '/storage/'.$user['image'];
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Upload Success. Reloading Page',
            'location' => '/profile'
        ]);
    }

    public  function save(Request $request){
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'username' => 'required|unique:users,username,'.$user->id
        ]);
        if (isset($request['password']) && $request['password'] != ''){
            $request->validate([
                'password' => 'required_with:confirm_password|same:confirm_password'
            ]);
            $user['password'] = Hash::make($request['password']);
        }
        $user['name'] = $request['name'];
        $user['username'] = $request['username'];
        $user['email'] = $request['email'];
        $user['address_line_1'] = $request['address_line_1'];
        $user['address_line_2'] = $request['address_line_2'];
        $user['city'] = $request['city'];
        $user['state'] = $request['state'];
        $user['country'] = $request['country'];
        $user['phone'] = $request['phone'];
        $user['postal_code'] = $request['postal_code'];
        $user->save();
        return response()->json(['message' => 'Profile Saved.']);
    }

    public function removeProfileImage(Request $request){
        $user = Auth::user();
        if (!isset($user))
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        if($user['image'] != '/assets/images/default.png') {
            $image = explode('/',$user['image']);
            Storage::delete('/public/'.$image[2]);
        }else
            return response()->json(['errors' => ['error' => 'Cannot Remove Default Image.']],500);
        $user['image'] = '/assets/images/default.png';
        $user->save();
        return response()->json([
            'message' => 'Image Removed.',
            'location' => '/profile'
        ]);
    }

    public function changeTwoFAStatus(Request $request){
        if (!Auth::user()->hasPermission('UPDATE'))
            return response()->json(['errors' => ['error' => 'Unauthorized Access.']],422);

        if (isset($request['user_id']))
            $user = User::find($request['user_id']);
        else
            $user = Auth::user();
        $user['2fa_mode'] = $user['2fa_mode']==='ENABLED'?'DISABLED':'ENABLED';
        if (!$user['2fa_secret'])
            $user['2fa_secret'] = GoogleAuthenticator::Make()->createSecret();
        $user->save();
        if(isset($request['user_id']))
            return response()->json([
                'message' => 'Status Updated.',
                'location' => '/businesses/accounts/'.$request['user_id']. '?tab=security'
            ]);
        return response()->json([
            'message' => 'Status Updated.',
            'location' => '/profile'
        ]);
    }
}
