<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OTIFSolutions\Laravel\Settings\Models\Setting;
use App\Models\Currency;

class SettingsController extends Controller
{
    public function index(){
        return view('dashboard.settings',[
            'page' => [
                'type' => 'dashboard'
            ],
            'currencies' => Currency::all()
        ]);
    }

    public  function save(Request $request){

        $request->validate([
            'reloadly_api_key' => 'required',
            'reloadly_api_secret' => 'required',
            'paypal_client_id' => 'required',
            'paypal_secret' => 'required',
            'stripe_publishable_key' => 'required',
            'stripe_secret_key' => 'required'
        ]);

        Setting::set('allow_customer_registration',@$request['allow_customer_registration'],'BOOL');
        Setting::set('reseller_discount',@$request['reseller_discount'],'DOUBLE');
        Setting::set('customer_rate',@$request['customer_rate'],'DOUBLE');
        Setting::set('stripe_publishable_key',@$request['stripe_publishable_key'],'STRING');
        Setting::set('stripe_secret_key',@$request['stripe_secret_key'],'STRING');
        Setting::set('paypal_client_id',@$request['paypal_client_id'],'STRING');
        Setting::set('paypal_secret',@$request['paypal_secret'],'STRING');
        $paypalApiMode = $request['paypal_api_mode']?'LIVE':'TEST';
        Setting::set('paypal_api_mode',$paypalApiMode,'STRING');
        Setting::set('reloadly_api_key',@$request['reloadly_api_key'],'STRING');
        Setting::set('reloadly_api_secret',@$request['reloadly_api_secret'],'STRING');
        Setting::set('reloadly_api_mode',@$request['reloadly_api_mode'],'BOOL');
        Setting::set('custom_theme',@$request['custom_theme'],'BOOL');
        Setting::set('ui_color',@$request['ui_color'],'STRING');
        Setting::set('icon_color',@$request['icon_color'],'STRING');
        Setting::set('topbar_background_color',@$request['topbar_background_color'],'STRING');
        Setting::set('sidebar_background_color',@$request['sidebar_background_color'],'STRING');
        Setting::set('sidebar_text_color',@$request['sidebar_text_color'],'STRING');
        Setting::set('sidebar_nav_item_color',@$request['sidebar_nav_item_color'],'STRING');
        Setting::set('same_billing_details',@$request['same_billing_details'],'BOOL');
        Setting::set('company_email',@$request['company_email'],'STRING');
        Setting::set('company_phone',@$request['company_phone'],'STRING');
        Setting::set('company_address_line_1',@$request['company_address_line_1'],'STRING');
        Setting::set('company_address_line_2',@$request['company_address_line_2'],'STRING');
        Setting::set('company_city',@$request['company_city'],'STRING');
        Setting::set('company_state',@$request['company_state'],'STRING');
        Setting::set('company_country',@$request['company_country'],'STRING');
        Setting::set('company_region',@$request['company_region'],'STRING');

        Setting::set('billing_email',@$request['same_billing_details']?@$request['company_email']:@$request['billing_email'],'STRING');
        Setting::set('billing_phone',@$request['same_billing_details']?@$request['company_phone']:@$request['billing_phone'],'STRING');
        Setting::set('billing_address_line_1',@$request['same_billing_details']?@$request['company_address_line_1']:@$request['billing_address_line_1'],'STRING');
        Setting::set('billing_address_line_2',@$request['same_billing_details']?@$request['company_address_line_2']:@$request['billing_address_line_2'],'STRING');
        Setting::set('billing_city',@$request['same_billing_details']?@$request['company_city']:@$request['billing_city'],'STRING');
        Setting::set('billing_state',@$request['same_billing_details']?@$request['company_state']:@$request['billing_state'],'STRING');
        Setting::set('billing_country',@$request['same_billing_details']?@$request['company_country']:@$request['billing_country'],'STRING');
        Setting::set('billing_region',@$request['same_billing_details']?@$request['company_region']:@$request['billing_region'],'STRING');

        $token = Auth::user()->getToken();
        if ($token === null)
            return response()->json([ 'errors' => ['error' => 'Api Auth Failed. Please Check Key/Secret and try again.']],422);
        Setting::set('reloadly_api_token',@$token,'STRING');

    }

    public function uploadFullLogo(Request $request){
        $request->validate([
            'full_logo' => 'required|file'
        ]);

        $image = Str::random(32).'.'.\File::extension($request['full_logo']->getClientOriginalName());
        $request['full_logo']->storeAs("public",$image);
        Setting::set('full_logo','/storage/'.$image,'STRING');

        return response()->json([
            'status' => 'success',
            'message' => 'Upload Success. Reloading Page',
            'location' => '/settings'
        ]);
    }

    public function removeFullLogo(Request $request){
        $logo = @Setting::get('full_logo');
        if($logo != '/assets/svgs/logo_text.svg') {
            $image = explode('/',$logo);
            Storage::delete('/public/'.$image[2]);
        }else
            return response()->json(['errors' => ['error' => 'Cannot Remove Default Image.']],500);
        Setting::set('full_logo','/assets/svgs/logo_text.svg','STRING');
        return response()->json([
            'message' => 'Full Logo Removed.',
            'location' => '/settings'
        ]);
    }

    public function uploadMiniLogo(Request $request){
        $request->validate([
            'mini_logo' => 'required|file'
        ]);

        $image = Str::random(32).'.'.\File::extension($request['mini_logo']->getClientOriginalName());
        $request['mini_logo']->storeAs("public",$image);
        Setting::set('mini_logo','/storage/'.$image,'STRING');

        return response()->json([
            'status' => 'success',
            'message' => 'Upload Success. Reloading Page',
            'location' => '/settings'
        ]);
    }

    public function removeMiniLogo(Request $request){
        $logo = @Setting::get('mini_logo');
        if($logo != '/assets/images/vuexy-logo.png') {
            $image = explode('/',$logo);
            Storage::delete('/public/'.$image[2]);
        }else
            return response()->json(['errors' => ['error' => 'Cannot Remove Default Image.']],500);
        Setting::set('mini_logo','/assets/images/vuexy-logo.png','STRING');
        return response()->json([
            'message' => 'Mini Logo Removed.',
            'location' => '/settings'
        ]);
    }
    public function uploadFavicon(Request $request){
        $request->validate([
            'favicon' => 'required|file'
        ]);

        $image = Str::random(32).'.'.\File::extension($request['favicon']->getClientOriginalName());
        $request['favicon']->storeAs("public",$image);
        Setting::set('favicon','/storage/'.$image,'STRING');

        return response()->json([
            'status' => 'success',
            'message' => 'Upload Success. Reloading Page',
            'location' => '/settings'
        ]);
    }

    public function removeFavicon(Request $request){
        $logo = @Setting::get('favicon');
        if($logo != '/assets/images/icon.png') {
            $image = explode('/',$logo);
            Storage::delete('/public/'.$image[2]);
        }else
            return response()->json(['errors' => ['error' => 'Cannot Remove Default Image.']],500);
        Setting::set('favicon','/assets/images/icon.png','STRING');
        return response()->json([
            'message' => 'Favicon Removed.',
            'location' => '/settings'
        ]);
    }
    public function uploadLoginLogo(Request $request){
        $request->validate([
            'login_logo' => 'required|file'
        ]);

        $image = Str::random(32).'.'.\File::extension($request['login_logo']->getClientOriginalName());
        $request['login_logo']->storeAs("public",$image);
        Setting::set('login_logo','/storage/'.$image,'STRING');

        return response()->json([
            'status' => 'success',
            'message' => 'Upload Success. Reloading Page',
            'location' => '/settings'
        ]);
    }

    public function removeLoginLogo(Request $request){
        $logo = @Setting::get('login_logo');
        if($logo != '/assets/images/logo.svg') {
            $image = explode('/',$logo);
            Storage::delete('/public/'.$image[2]);
        }else
            return response()->json(['errors' => ['error' => 'Cannot Remove Default Image.']],500);
        Setting::set('login_logo','/assets/images/logo.svg','STRING');
        return response()->json([
            'message' => 'Login Logo Removed.',
            'location' => '/settings'
        ]);
    }
}
