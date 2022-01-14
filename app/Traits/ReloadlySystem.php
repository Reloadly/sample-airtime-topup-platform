<?php
namespace App\Traits;

use App\Models\Operator;
use OTIFSolutions\CurlHandler\Curl;
use OTIFSolutions\Laravel\Settings\Models\Setting;

trait ReloadlySystem {

    public function getReloadlyApiUrlAttribute(){
        return Setting::get('reloadly_api_mode')?'https://topups.reloadly.com':'https://topups-sandbox.reloadly.com';
    }

    public function getReloadlyGiftApiUrlAttribute(){
        return Setting::get('reloadly_api_mode')?'https://giftcards.reloadly.com':'https://giftcards-sandbox.reloadly.com';
    }

    public function getToken(){

        $response = Curl::Make()->POST->url("https://auth.reloadly.com/oauth/token")->header([
            "Content-Type:application/json"
        ])->body([
            'client_id' => Setting::get('reloadly_api_key'),
            'client_secret' => Setting::get('reloadly_api_secret'),
            'grant_type' => 'client_credentials',
            'audience' => $this['reloadly_api_url']
        ])->execute();

        \App\Models\Log::create([
            'task' => 'GET_TOKEN',
            'params' => '',
            'response' => $response
        ]);
        return isset($response['access_token'])?$response['access_token']:null;
    }

    public function getCountries(){
        $response = Curl::Make()->GET->url($this['reloadly_api_url']."/countries")->header([
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ])->execute();

        \App\Models\Log::create([
            'task' => 'GET_COUNTRIES',
            'params' => '',
            'response' => $response
        ]);
        return $response;
    }

    public function getOperators($page=1){
        $response = Curl::Make()->GET->url($this['reloadly_api_url']."/operators?page=$page&size=200&includeBundles=true&includeData=true&includePin=true&simplified=false&suggestedAmounts=true&suggestedAmountsMap=true")->header([
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ])->execute();
        \App\Models\Log::create([
            'task' => 'GET_OPERATORS',
            'params' => '',
            'response' => $response
        ]);
        return $response;
    }

    public function getOperatorsDiscount($page=1){
        $response = Curl::Make()->GET->url($this['reloadly_api_url']."/operators/commissions?page=$page&size=200&includeBundles=true&includeData=true&includePin=true&simplified=false&suggestedAmounts=true&suggestedAmountsMap=true")->header([
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ])->execute();
        \App\Models\Log::create([
            'task' => 'GET_OPERATORS_DISCOUNTS',
            'params' => '',
            'response' => $response
        ]);
        return $response;
    }

    public function getBalance(){
        $response = Curl::Make()->GET->url($this['reloadly_api_url']."/accounts/balance")->header([
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ])->execute();
        if (isset($response['currencyCode']))
        {
            Setting::set('reloadly_currency',$response['currencyCode'],'STRING');
            $this->save();
        }
        return isset($response['balance'], $response['currencyCode']) ?$response['balance'].' '.$response['currencyCode']:'---';
    }

    public function autoDetectOperator($phone,$iso,$fileId){
        $response = Curl::Make()->GET->url($this['reloadly_api_url']."/operators/auto-detect/phone/$phone/country-code/".$iso."?&includeBundles=true")->header([
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ])->execute();
        \App\Models\Log::create([
            'task' => 'AUTO_DETECT',
            'params' => ' FILE:'.$fileId,
            'response' => $response
        ]);
        return isset($response['operatorId'])?Operator::where('rid',$response['operatorId'])->first():null;
    }

    public function getPromotions($page=1){
        $response = Curl::Make()->GET->url($this['reloadly_api_url']."/promotions?page=$page")->header([
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ])->execute();
        \App\Models\Log::create([
            'task' => 'GET_PROMOTIONS',
            'params' => '',
            'response' => $response
        ]);
        return $response;
    }

    public function getGiftTokenAttribute(){
        $response = Curl::Make()->POST->url("https://auth.reloadly.com/oauth/token")->header([
            "Content-Type:application/json"
        ])->body([
            'client_id' => Setting::get('reloadly_api_key'),
            'client_secret' => Setting::get('reloadly_api_secret'),
            'grant_type' => 'client_credentials',
            'audience' => $this['reloadly_gift_api_url']
        ])->execute();
        return isset($response['access_token'])?$response['access_token']:null;
    }

    public function getReloadlyGiftProducts($page=1){
        return Curl::Make()->GET->url($this['reloadly_gift_api_url']."/products?page=$page&size=200")->header([
            "Content-Type:application/json",
            "Authorization: Bearer ".$this['gift_token']
        ])->execute();
    }

    public function orderReloadlyGiftProducts($rid, $iso, $quantity, $price, $identifier, $senderName, $email){
        return Curl::Make()->POST->url($this['reloadly_gift_api_url']."/orders")->header([
            "Content-Type:application/json",
            "Authorization: Bearer ".$this['gift_token']
        ])->body([
            'productId' => $rid,
            'countryCode' => $iso,
            'quantity' => $quantity,
            'unitPrice' => $price,
            'customIdentifier' => $identifier,
            'senderName' => $senderName,
            'recipientEmail' => $email
        ])->execute();
    }
}
