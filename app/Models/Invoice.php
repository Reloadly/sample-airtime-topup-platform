<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'payment_intent_response' => 'array',
        'paypal_response' => 'array'
    ];

    public function topups(){
        return $this->hasMany('App\Models\Topup');
    }

    public function topup(){
        return $this->hasOne('App\Models\Topup', 'invoice_id');
    }
    public function gift_card(){
        return $this->hasOne(GiftCardTransaction::class,'invoice_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
