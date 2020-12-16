<?php
namespace App\Traits;

use OTIFSolutions\Laravel\Settings\Models\Setting;
use App\Operator;

trait ReloadlySystem {

    public function getReloadlyApiUrlAttribute(){
        return Setting::get('reloadly_api_mode')?'https://topups.reloadly.com':'https://topups-sandbox.reloadly.com';
    }

    public function getToken(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://auth.reloadly.com/oauth/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));

        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode([
            'client_id' => Setting::get('reloadly_api_key'),
            'client_secret' => Setting::get('reloadly_api_secret'),
            'grant_type' => 'client_credentials',
            'audience' => $this['reloadly_api_url']
        ]));

        $response = curl_exec($ch);
        curl_close($ch);
        \App\Models\Log::create([
            'task' => 'GET_TOKEN',
            'params' => '',
            'response' => $response
        ]);
        $response = json_decode($response);

        return isset($response->access_token)?$response->access_token:null;
    }

    public function getCountries(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this['reloadly_api_url']."/countries");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        \App\Models\Log::create([
            'task' => 'GET_COUNTRIES',
            'params' => '',
            'response' => $response
        ]);
        return json_decode($response);
    }

    public function getOperators($page=1){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this['reloadly_api_url']."/operators?page=$page&size=200&includeBundles=true&includeData=true&includePin=true&simplified=false&suggestedAmounts=true&suggestedAmountsMap=true");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        \App\Models\Log::create([
            'task' => 'GET_OPERATORS',
            'params' => '',
            'response' => $response
        ]);
        return json_decode($response);
    }

    public function getOperatorsDiscount($page=1){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this['reloadly_api_url']."/operators/commissions?page=$page&size=200&includeBundles=true&includeData=true&includePin=true&simplified=false&suggestedAmounts=true&suggestedAmountsMap=true");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        \App\Models\Log::create([
            'task' => 'GET_OPERATORS_DISCOUNTS',
            'params' => '',
            'response' => $response
        ]);
        return json_decode($response);
    }

    public function getBalance(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this['reloadly_api_url']."/accounts/balance");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        if (isset($response->currencyCode))
        {
            Setting::set('reloadly_currency',@$response->currencyCode,'STRING');
            $this->save();
        }
        return isset($response->balance)&&isset($response->currencyCode)?$response->balance.' '.$response->currencyCode:'---';
    }

    public function autoDetectOperator($phone,$iso,$fileId){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this['reloadly_api_url']."/operators/auto-detect/phone/$phone/country-code/".$iso."?&includeBundles=true");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        \App\Models\Log::create([
            'task' => 'AUTO_DETECT',
            'params' => ' FILE:'.$fileId,
            'response' => $response
        ]);
        $response = \GuzzleHttp\json_decode($response);

        return isset($response->operatorId)?Operator::where('rid',$response->operatorId)->first():null;
    }

    public function getPromotions($page=1){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this['reloadly_api_url']."/promotions?page=$page");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        \App\Models\Log::create([
            'task' => 'GET_PROMOTIONS',
            'params' => '',
            'response' => $response
        ]);
        return json_decode($response);
    }
}
