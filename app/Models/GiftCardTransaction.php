<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCardTransaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'product' => 'array',
        'response' => 'array'
    ];

    protected $appends = ['message'];

    public function invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function sender_currency(){
        return $this->belongsTo(Currency::class,'sender_currency_id');
    }

    public function recipient_currency(){
        return $this->belongsTo(Currency::class,'recipient_currency_id');
    }

    public function product(){
        return $this->belongsTo(GiftCardProduct::class,'product_id');
    }

    public function sendTransaction(){
        $response = User::admin()->orderReloadlyGiftProducts($this['product']['rid'],$this['product']['country']['iso'],1,$this['recipient_amount'],$this['reference'],$this['user']['name'],$this['email']);

        if((isset($response->status)) && ($response->status === 'SUCCESSFUL')){
            $this['transaction_id'] = $response->transactionId;
            $this['status'] = 'SUCCESS';
        }else{
            $this['status'] = 'FAIL';
        }
        $this['response'] = $response;
        $this->save();
    }

    public function getMessageAttribute(){
        switch ($this['status']){
            case "PENDING":
                return "Transaction is paid. But its pending transaction. Please wait a few minuites for the status to update.";
            case "SUCCESS":
                return "Transaction completed successfully.";
            case "FAIL":
                return isset($this['response']['message'])?$this['response']['message']: "Transaction Failed. No response";
            case "PENDING_PAYMENT":
                return "Transaction is pending payment";
            case "REFUNDED":
                return "Gift Card Transaction has been refunded. It failed due to Error : ".(isset($this['response']['message'])?$this['response']['message']: "Unknown");
            default:
                return "Error : Unknown Status found.";
        }
    }
}
