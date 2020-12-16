<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'response' => 'array'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function invoice(){
        return $this->belongsTo('App\Models\Invoice');
    }

    public function topup(){
        return $this->belongsTo('App\Models\Topup');
    }


}
