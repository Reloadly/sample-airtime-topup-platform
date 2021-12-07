<?php

namespace App\Http\Controllers;

use App\Traits\GoogleAuthenticator;
use App\Models\System;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use OTIFSolutions\ACLMenu\Models\UserRole;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']], isset($request['remember-me'])) ||
            Auth::attempt(['username' => $request['email'], 'password' => $request['password']], isset($request['remember-me']))) {
            return response()->json([
                'location' => '/dashboard',
                'message' => 'Login Success. Redirecting Now'
            ]);
        }else return response()->json(['errors' => [
            'error' => 'Authentication Failed'
        ]],422);
    }

    public function getRegister(){
        if(Setting::get('allow_customer_registration'))
            return view('dashboard.register');
        else
            return view('dashboard.no-register');
    }

    public function register(Request $request){
        if(!Setting::get('allow_customer_registration'))
            return response()->json(['errors' => ['error' => 'Registration not allowed.']],422);
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required_with:confirm_password|same:confirm_password',
            'accept_terms' => 'required'
        ]);
        $user = new User();
        $user['name'] = $request['name'];
        $user['username'] = $request['username'];
        $user['email'] = $request['email'];
        $user['user_role_id'] = UserRole::where('name','CUSTOMER')->first()['id'];
        $user['password'] = Hash::make($request['password']);
        $user->save();

        System::registerUserWithStripe($user);

     //   System::sendEmail($user->email,'mails.auth.signup', ['user' => $user]);

        Auth::login($user);
        return response()->json([
            'location' => '/dashboard',
            'message' => 'Registration Complete. Redirecting Now'
        ]);
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    public function forgotPassword(Request $request){
        $request->validate([
            'email' => 'required'
        ]);
        $user = User::where('email',$request['email'])->first();
        if ($user === null)
            return response()->json(['errors' => [ 'error' => 'User not found.']],422);
        else{
            $current = $user['password'];
            $password = Str::random(40);
            $user['password'] = Hash::make($password);
            $user->save();
            System::sendEmail($user->email,'mails.auth.forgot-password', ['password' => $password]);
            return response()->json([
                'location' => '/login',
                'message' => 'Password Reset. Please check email for updated password.'
            ]);
        }
    }

    public function sendCode(Request $request){
        $user = Auth::user();
        if ($user){
            if (!$user['2fa_secret'])
            {
                $user['2fa_mode'] = 'DISABLED';
                $user->save();
                return response()->json(['errors' => ['error' => 'Invalid Request.']],422);
            }
            return response()->json([
                'message' => 'Please check OTP on Google Authenticator App.'
            ]);
        }else
            return response()->json(['errors' => ['error' => 'Invalid Request.']],422);
    }

    public function tfaVerify(Request $request){
        $user = Auth::user();
        if ($user){
            $request->validate([
                'code' => 'required'
            ]);
            if (GoogleAuthenticator::Make()->verifyCode(
                $user['2fa_secret'],
                $request['code'],
                2
            )){
                $request->session()->put('2fa_code',$request['code']);
                $request->session()->put('2fa_code_time',floor(time() / 30));
                $return = '/dashboard';
                if ($request['return'] && $request['return'] !== '')
                    $return = '/'.$request['return'];
                return response()->json([
                    'message' => 'PIN Verified',
                    'location' => $return
                ]);
            }else
                return response()->json(['errors' => ['error' => 'Invalid PIN']],422);
        }else
            return response()->json(['errors' => ['error' => 'Invalid Request.']],422);

    }
}
