<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class Operator extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['select_amounts'];

    protected $casts = [
        'logo_urls' => 'array',
        'fixed_amounts' => 'array',
        'fixed_amounts_descriptions' => 'array',
        'suggested_amounts' => 'array',
        'suggested_amounts_map' => 'array',
        'local_fixed_amounts' => 'array',
        'local_fixed_amounts_descriptions' => 'array',
        'geographical_recharge_plans' => 'array'
    ];

    public function country(){
        return $this->belongsTo('App\Models\Country');
    }

    public  function discount(){
        return $this->hasOne('App\Models\Discount');
    }

    public function topups(){
        return $this->hasMany('App\Models\Topup');
    }

   /* public function numbers(){
        return $this->hasMany('App\MobileNumber');
    }*/

    public function promotions(){
        return $this->hasMany('App\Models\Promotion');
    }

    public function resellers(){
        return $this->belongsToMany(User::class,'reseller_rates','operator_id','user_id')->withPivot(['international_discount', 'local_discount']);
    }

    public function getFxRateAttribute($fx){
        $user = Auth::user();
        if(isset($user) && ($user['user_role']['name'] == 'RESELLER'))
            return  $fx;
        elseif(Setting::get('customer_rate'))
            return ($fx * (1 - ( Setting::get('customer_rate') / 100)));

        return $fx;
    }

    public function getFxForAmount($amount){
        $system = User::admin();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $system['reloadly_api_url']."/operators/fx-rate");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ));

        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode([
            'operatorId' => $this['rid'],
            'currencyCode' => Setting::get('reloadly_currency'),
            'amount' => $amount
        ]));

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        return isset($response->fxRate)?$response->fxRate:-1;
    }

    public function getSelectAmountsAttribute(){
        return $this['denomination_type'] === 'RANGE'?$this['suggested_amounts']:$this['fixed_amounts'];
    }
}
