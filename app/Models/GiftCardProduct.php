<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class GiftCardProduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'logo_urls' => 'array',
        'fixed_recipient_denominations' => 'array',
        'fixed_sender_denominations' => 'array',
        'fixed_denominations_map' => 'array',
        'brand' => 'array',
        'country' => 'array',
        'redeem_instruction' => 'array'
    ];
    public $appends = ['amounts'];

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
    public function getAmountsAttribute(){
        if (isset($this->pivot->discount))
            $discount = $this->pivot->discount;
        else
            $discount = 0;
        $amounts = [];
        if ($this['denomination_type'] === "FIXED"){
            foreach ($this['fixed_denominations_map'] as $key => $denomonation)
            {
                $amounts[$key] = $denomonation + $this['sender_fee'];
                $amounts[$key] *= (1 - ($discount / 100));
                $amounts[$key] = round($amounts[$key],2);
            }
        }else{
            $amounts[] = $this['min_recipient_denomination'];
            $amounts[] = $this['max_recipient_denomination'];
        }
        return $amounts;
    }
}
