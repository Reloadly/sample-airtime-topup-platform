<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class Topup extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'response' => 'array',
        'pin' => 'array'
    ];

    public function operator(){
        return $this->belongsTo('App\Models\Operator');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function invoice(){
        return $this->belongsTo('App\Models\Invoice');
    }

    public function file_entry(){
        return $this->belongsTo('App\Models\FileEntry');
    }

    public function sendTopup($sendResponse=false){
        $system = User::admin();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $system['reloadly_api_url']."/topups");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".Setting::get('reloadly_api_token')
        ));

        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode([
            'recipientPhone' => [
                'countryCode' => $this['operator']['country']['iso'],
                'number' => $this['number']
            ],
            'operatorId' => $this['operator']['rid'],
            'amount' => $this['is_local']?$this['topup']:$this['topup']/$this['operator']['fx_rate'],
            'useLocalAmount' => $this['is_local']?"true":"false"
        ]));

        $response = curl_exec($ch);
        curl_close($ch);
        \App\Models\Log::create([
            'task' => 'SEND_TOPUP',
            'params' => 'TOPUP_ID:'.$this['id'].' PHONE:'.$this['number'].' TOPUP:'.$this['topup'],
            'response' => $response
        ]);
        $this['response'] = json_decode($response);
        if (isset($this['response']['errorCode']) && $this['response']['errorCode'] != null && $this['response']['errorCode'] != '')
            $this['status'] = 'FAIL';
        else{
            $this['status'] = 'SUCCESS';
            if (isset($this['response']['balanceInfo']['oldBalance']) && isset($this['response']['balanceInfo']['newBalance']))
                $this['topup'] = $this['response']['balanceInfo']['oldBalance'] - $this['response']['balanceInfo']['newBalance'];
            if (isset($this['response']['pinDetail']))
                $this['pin'] = $this['response']['pinDetail'];
        }
        $this->save();
        if($sendResponse)
            return $this['status'];
    }
}
