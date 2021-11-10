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
}
