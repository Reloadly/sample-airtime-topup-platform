<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [ 'calling_codes' => 'array' ];

    protected $hidden = ['created_at', 'updated_at', 'calling_codes'];

    public  function operators(){
        return $this->hasMany('App\Models\Operator');
    }

    public  function gifts(){
        return $this->hasMany(GiftCardProduct::class,'country_id');
    }


    public static function GetForInputField(){
        return Country::where('calling_codes','!=','[]')->get()->map(function($item){
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'iso2' => strtolower($item['iso']),
                'dialCode' => str_replace('+','',$item['calling_codes'][0])
            ];
        });
    }
}
